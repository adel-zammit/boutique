<?php


namespace App\Admin\Controller;


use App\Entity\Categories;
use App\Entity\ProductImg;
use App\Entity\Products;
use App\Entity\TechnicalDataSheet;
use App\Entity\TechnicalDataSheetValue;
use App\Repository\categoryTree;
use Base\BaseApp;
use Base\Mvc\ParameterBag;
use Base\Repository;
use Base\Util\MessageBbCode;

class Product extends AbstractController
{
    /**
     * @var string[]
     */
    protected $extensionType = ['.jpeg', '.png', '.jpg'];

    /**
     * @var int
     */
    protected $perPageProduct = 20;

    /**
     *
     */
    public function actionIndex()
    {
        $products = $this->finder('App:Products')
            ->order('product_date')
            ->limitByPage(1, $this->perPageProduct);
        $viewParams = [
            'products' => $products->fetch(),
            'total' => $products->total(),

            'categoryTree' => $this->getRepoCategoryTree()->tree(),
            'categories' => $this->getRepoCategoryTree()->treeCategorySelect()
            ];
        $this->view('product_list', $viewParams);
    }

    /**
     * @return array|\Base\Reply\Redirect
     */
    public function actionCategories()
    {
        if($this->isPost())
        {
            return $this->redirect($this->app()->buildLink('admin:product/add', null, ['category_id' => $this->filter('category_id', 'int')]));
        }
        $params = [
            'namePage' => 'dd',
            'saveURL' => $this->app()->buildLink('admin:product/categories'),
            'nameButton' => 'Save',
            'logoButton' => 'far fa-save',
            'ajax' => false,
            'Input' => [
                'category_id' => [
                    'type' => 'selector',
                    'options' => $this->getRepoCategoryTree()->treeCategorySelect(),
                    'required' => true,
                    'title' => 'Titre',
                    'description' => ''
                ]
            ]
        ];
        return $this->formAjax($params);
    }

    /**
     * @param Products $product
     * @throws \Exception
     */
    protected function AddEditProduct(Products $product)
    {
        if($product->isInsert())
        {
            /** @var Categories $category */
            $category = $this->BaseApp()->find('App:Categories', $this->filter('category_id', 'int'));
        }
        else
        {
            $category = $this->BaseApp()->find('App:Categories', $product->category_id);
        }
        $technicalDataSheet = $this->finder('App:TechnicalDataSheet')
            ->where('category_id', $category->category_id)
            ->fetch();
        $viewParams = [
            'category' => $category,
            'technicalDataSheet' => $technicalDataSheet,
            'product' => $product
        ];
        $this->view('product_edit', $viewParams);
    }

    /**
     *
     */
    public function actionAdd()
    {
        $product = $this->create('App:Products');
        $this->AddEditProduct($product);
    }

    /**
     * @param ParameterBag $params
     * @throws \Exception
     */
    public function actionEdit(ParameterBag $params)
    {
        $product = $this->assertProductExists($params->product_id);
        $this->AddEditProduct($product);
    }

    /**
     * @param Products $product
     * @return array
     * @throws \Exception
     */
    protected function saveProductProcess(Products $product)
    {
        $entityInput = $this->filter([
            'title' => 'str',
            'category_id' => 'int',
            'description' => 'str',
            'price' => 'float',
            'stock' => 'int',
            'technical' => 'array',
            'product_img' => 'array'
        ]);
        /** @var Products $product */
        $errors = [];
        if(empty($entityInput['title']))
        {
            $errors[] = $this->BaseApp()->phrase('please_enter_value_for_required_field_x', [
                'field' => $this->BaseApp()->phrase('title')
            ]);
        }
        if(!MessageBbCode::testLengthMessage($entityInput['description']))
        {
            $errors[] = $this->BaseApp()->phrase('please_enter_value_for_required_field_x', [
                'field' => $this->BaseApp()->phrase('description')
            ]);
        }
        if($entityInput['price'] < 0.01)
        {
            $errors[] = $this->BaseApp()->phrase('please_enter_value_for_required_field_x', [
                'field' => $this->BaseApp()->phrase('price')
            ]);
        }
        if(empty($errors))
        {
            $product->title = $entityInput['title'];
            $product->description = MessageBbCode::renderHtmlToBbCode($entityInput['description']);
            $product->category_id = $entityInput['category_id'];
            $product->price = $entityInput['price'];
            $product->stock = $entityInput['stock'];
            $product->save();
            foreach ($entityInput['technical'] as $k => $t)
            {
                if($product->isInsert())
                {
                    /** @var TechnicalDataSheetValue $TechnicalDataSheetValue */
                    $TechnicalDataSheetValue = $this->create('App:TechnicalDataSheetValue');
                    $TechnicalDataSheetValue->product_id = $product->product_id;
                    $TechnicalDataSheetValue->technical_data_sheet_id = $k;
                    $TechnicalDataSheetValue->value = MessageBbCode::renderHtmlToBbCode($t);
                    $TechnicalDataSheetValue->save();
                }
                else
                {
                    /** @var TechnicalDataSheetValue $TechnicalDataSheetValue */
                    $TechnicalDataSheetValue =  $this->BaseApp()->find('App:TechnicalDataSheetValue', $k);
                    $TechnicalDataSheetValue->value = MessageBbCode::renderHtmlToBbCode($t);
                    $TechnicalDataSheetValue->save();
                }
            }
            if($product->isInsert())
            {
                foreach ($entityInput['product_img'] as $imgId)
                {
                    /** @var ProductImg $productImg */
                    $productImg = $this->getDb()->finder('App:ProductImg')
                        ->where('product_img_id', $imgId)->fetchOne();
                    $productImg->product_id = $product->product_id;
                    $productImg->save();
                }
            }
            if(!empty($_FILES['file']))
            {
                $checkImg = $this->checkLogo();
                if(empty($checkImg['error']))
                {
                    $this->setImg($product);
                }
            }
        }
        return $this->setErrorByFromByJason($errors, $this->app()->buildLink('admin:product'));
    }


    /**
     * @param ParameterBag $params
     * @return array
     * @throws \Exception
     */
    public function actionSave(ParameterBag $params)
    {
        if($params->product_id)
        {
            $product = $this->assertProductExists($params->product_id);
        }
        else
        {
            $product = $this->create('App:Products');
        }

        return $this->saveProductProcess($product);
    }

    /**
     * @param ParameterBag $params
     * @return array
     * @throws \Exception
     */
    public function actionSaveImg(ParameterBag $params)
    {
        if($params->product_id)
        {
            $product = $this->assertProductExists($params->product_id);
        }
        else
        {
            $product = null;
        }
        /** @var ProductImg $productImg */
        $productImg = $this->create('App:ProductImg');
        $checkAvatar = $this->checkLogo();
        $errors = [];
        if(isset($checkAvatar['error'] ))
        {
            $errors[] = $checkAvatar['error'];
        }
        if(empty($errors))
        {
            $productImg->product_id = $product !== null ? $product->product_id : 0;
            $productImg->save();
            $this->setLogo($productImg);
            return $this->setViewAjax([
                'urlLog' => $productImg->getUrlLogoBypath(),
                'id' => $productImg->product_img_id,
                'name' => $productImg->name,
                'urlDelete' => $this->app()->buildLink('admin:product/delete-img')
            ]);
        }
        return $this->setViewAjax([
            'urlLog' => '',
            'id' => 0,
            'name' => '',
            'urlDelete' => $this->app()->buildLink('admin:product/delete-img')
        ]);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function actionUpdateProduct()
    {
        $productId = $this->filter('productId', 'int');
        $contentType = $this->filter('contentType', 'str');
        /** @var Products $product */
        $product = BaseApp::find('App:Products',$productId);
        $typeInput = $this->filter('typeInput', 'str');
        $value = $this->filter('value', $typeInput);

        switch ($contentType)
        {
            case 'title' :
                $product->title = $value;
                $product->save();
                break;
            case 'stock' :
                $product->stock = $value;
                $product->save();
                break;
            case 'price' :
                $product->price = $value;
                $product->save();
                break;
            case 'category' :
                $product->category_id = $value;
                $product->save();
                $product->moveProduct();
                break;
        }
        return $this->setViewAjax([]);
    }
    public function getPrice()
    {

    }
    /**
     * @return array
     */
    public function actionScroll()
    {
        $page = $this->filter('offset', 'int');
        $products = $this->finder('App:Products')
            ->order('product_date')
            ->limitByPage($page, $this->perPageProduct);
        $this->applyFilter($products, $this->filter('filterText', 'str'), $this->filter('categoryId', 'int'), $this->filter('stock', 'int'));
        $productsOutput = $this->getProductOutput($products, $output);

        return $this->setViewAjax([
            'products' => $productsOutput,
            'categories' => $this->getRepoCategoryTree()->treeCategorySelect()
        ]);
    }

    /**
     * @return array
     */
    public function actionSearch()
    {
        $q = $this->filter('q', 'str');
        $page = $this->filter('offset', 'int');
        $totalProducts = $page * $this->perPageProduct;
        $products = $this->finder('App:Products')
            ->order('product_date')
            ->limit($totalProducts);

        $output = [];
        $this->applyFilter($products, $q, $this->filter('categoryId', 'int'), $this->filter('stock', 'int'));
        $output = $this->getProductOutput($products, $output);
        return $this->setViewAjax([
            'products' => $output,
            'total' => $products->total(),
            'categories' => $this->getRepoCategoryTree()->treeCategorySelect()
        ]);
    }

    /**
     * @param $products
     * @param $q
     * @param $categoryId
     * @param $stock
     */
    protected function applyFilter($products, $q, $categoryId, $stock)
    {
        if(!empty($q))
        {
            $qToArray = explode(' ', $q);
            foreach ($qToArray as $qExplode)
            {
                $products->where('title', 'like', '%' . $qExplode . '%');
            }
        }
        if(!empty($categoryId))
        {
            $products->where('category_id', $categoryId);
        }
        if($stock == 2)
        {
            $products->where('stock', 0);
        }
    }

    /**
     * @param $products
     * @param array $output
     * @return array
     */
    protected function getProductOutput($products, &$output = [])
    {
        /** @var Products $product */
        foreach ($products->fetch() as $product)
        {
            $output[] = [
                'id' => $product->product_id,
                'categoryId' => $product->category_id,
                'img' => \Base\Util\Img::getImg($product, 'icon_date', 'defaultProduct', 'default_img_product', 'm'),
                'title' => $product->title,
                'stock' => $product->stock,
                'price' => $product->price,
                'urlEdit' => $this->app()->buildLink('admin:product/edit', $product),
                'urlDelete' => $this->app()->buildLink('admin:product/delete', $product),
            ];
        }
        return $output;
    }

    /**
     *
     */
    public function actionDeleteImg()
    {
        $productImg = $this->assertProductImgExists($this->filter('id', 'int'));
        $productImg->delete();
        return $this->setViewAjax([
            'imgId' => $this->filter('id', 'int')
        ]);
    }
    /**
     * @param ParameterBag $params
     * @return array|\Base\Reply\Redirect|string[]
     * @throws \Exception
     */
    public function actionDelete(ParameterBag $params)
    {
        /** @var Products $address */
        $address = $this->assertProductExists($params->product_id);
        if($this->isPost())
        {
            $address->delete();
            return $this->redirect($this->app()->buildLink('Pub:product'));
        }
        else
        {
            $title = $address->title;
            $linkEdit = $this->app()->buildLink('Pub:product/edit', $address);
            $linkDeleted = $this->app()->buildLink('Pub:product/delete', $address);
            return $this->Delete($linkEdit, $linkDeleted, $title);
        }
    }

    /**
     * @return array
     */
    public function checkLogo()
    {
        $type = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $output = [
            'type' => $type
        ];
        if (!in_array("." . $type, $this->extensionType)) {
            $output['error'] = "Format d'image autorisé: " . implode(", ", $this->extensionType);
        }
        return $output;
    }

    /**
     * @param ProductImg $productImg
     * @throws \Exception
     */
    public function setLogo(ProductImg $productImg)
    {
        $pathAvatar = 'data/product_img/';
        $name = $productImg->product_img_id . ".jpg";
        foreach (scandir($pathAvatar) as $avatar) {
            if (pathinfo($avatar, PATHINFO_FILENAME) == pathinfo($name, PATHINFO_FILENAME)) {
                $path = $pathAvatar . $avatar;
                unset($path);
            }
        }
        move_uploaded_file($_FILES["file"]["tmp_name"], $pathAvatar . $name);
        $productImg->name = $_FILES["file"]["name"];
        $productImg->save();
    }
    /**
     * @return array
     */
    public function checkImg()
    {
        $type = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $output = [
            'type' => $type
        ];
        if (!in_array("." . $type, $this->extensionType)) {
            $output['error'] = "Format d'image autorisé: " . implode(", ", $this->extensionType);
        }
        return $output;
    }

    /**
     * @param Products $product
     * @throws \Exception
     */
    public function setImg(Products $product)
    {
        $pathAvatar = 'data/product_img_default/';
        $name = $product->product_id . ".jpg";
        foreach (scandir($pathAvatar) as $avatar) {
            if (pathinfo($avatar, PATHINFO_FILENAME) == pathinfo($name, PATHINFO_FILENAME)) {
                $path = $pathAvatar . $avatar;
                unset($path);
            }
        }
        move_uploaded_file($_FILES["file"]["tmp_name"], $pathAvatar . $name);
        $product->icon_date = BaseApp::time();
        $product->save();
    }
    /**
     * @return categoryTree|Repository
     */
    protected function getRepoCategoryTree()
    {
        return $this->repository('App:categoryTree');
    }

    /**
     * @param $id
     * @param null $with
     * @param null $phraseKey
     * @return mixed
     * @throws \Exception
     */
    protected function assertProductExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('App:Products', $id, $with, $phraseKey);
    }
    /**
     * @param $id
     * @param null $with
     * @param null $phraseKey
     * @return mixed
     * @throws \Exception
     */
    protected function assertProductImgExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('App:ProductImg', $id, $with, $phraseKey);
    }
}