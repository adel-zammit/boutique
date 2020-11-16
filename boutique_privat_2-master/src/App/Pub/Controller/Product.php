<?php


namespace App\Pub\Controller;


use App\Entity\Carts;
use App\Entity\Categories;
use App\Entity\Products;
use App\Entity\Review;
use App\Repository\categoryTree;
use Base\BaseApp;
use Base\Mvc\ParameterBag;
use Base\Repository;

class Product extends AbstractController
{

    /**
     * @param ParameterBag $params
     * @return mixed
     */
    public function actionIndex(ParameterBag $params)
    {
        if($params->product_id)
        {
            return $this->rerouteController(__CLASS__, 'View', $params);
        }
        $viewParams = [
            'categoryTree'=> $this->getRepoCategoryTree()
        ];
        $this->view('categories', $viewParams);
    }

    /**
     * @param ParameterBag $params
     * @throws \Exception
     */
    public function actionView(ParameterBag $params)
    {
        /** @var Products $product */
        $product = $this->assertProductExists($params->product_id);
        $reviews = $this->finder('App:Review')
            ->where('product_id', $product->product_id);
        $page = $params->page;
        $perPage = 10;
        $reviews->limitByPage($page, $perPage);

        $testBuyArticle = $this->finder('App:ItemsPurchased')
            ->where([
                'product_id' => $product->product_id,
                'user_id' => BaseApp::visitor()->user_id
            ])->total();
        $viewParams = [
            'product' => $product,
            'reviews' => $reviews->fetch(),
            'total' => $reviews->total(),

            'page' => $page,
            'perPage' => $perPage,

            'testBuyArticle' => $testBuyArticle
        ];
        $this->view('product_view', $viewParams, $product->title);
    }

    /**
     * @param ParameterBag $params
     * @return array
     * @throws \Exception
     */
    public function actionAvie(ParameterBag $params)
    {
        /** @var Products $product */
        $product = $this->assertProductExists($params->product_id);
        $input = $this->filter([
            'rating' => 'int',
            'review' => 'str'
        ]);
        $errors = [];
        if(empty($input['rating']))
        {
            $errors[] = 'Veuillez sélectionner une étoile.';
        }
        if(strlen($input['review']) < 100)
        {
            $errors[] = 'Veuillez fournir une critique dans votre évaluation, qui contient plus de 100 caractères.';
        }
        if(empty($errors))
        {
            $visitor = BaseApp::visitor();
            /** @var Review $avie */
            $avie = $this->create('App:Review');
            $avie->rating = $input['rating'];
            $avie->review = $input['review'];
            $avie->product_id = $product->product_id;
            $avie->user_id = $visitor->user_id;
            $avie->username = $visitor->username;
            $avie->save();
            $product->rebuildRating();
        }
        return $this->setErrorByFromByJason($errors, $this->app()->buildLink('Pub:product', $product) . '#tab-rating');
    }
    /**
     * @param ParameterBag $params
     * @throws \Exception
     */
    public function actionCategories(ParameterBag $params)
    {
        /** @var Categories $category */
        $category = $this->assertCategoryExists($params->category_id);
        $products = $this->finder('App:Products')
            ->order('product_date')
            ->where('category_id', $category->category_id);
        $perPage = 10;
        $page = $params->page;
        $max = $products->fetchColumn(['max(price) AS max_price'])['max_price'];
        $min = $products->fetchColumn(['min(price) AS min_price'])['min_price'];
        $filter = $this->getFilters();

        $this->applyFilters($filter, $products);

        $products->limitByPage($page, $perPage);

        $viewParams = [
            'category' => $category,
            'products' => $products->fetch(),
            'total' => $products->total(),

            'max' =>  $max,
            'min' =>  $min,

            'perPage' => $perPage,
            'page' => $page,

            'filter' => $filter,
            'categoryTree'=> $this->getRepoCategoryTree(),
        ];
        $this->view('category_view', $viewParams, $category->name);
    }

    /**
     * @return array
     */
    protected function getFilters()
    {
        $filter = $this->filter([
            'min_price' => 'str',
            'max_price' => 'str',
            'rating' => 'int'
        ]);
        $outputFilter = [];
        if(!empty($filter['min_price']) && !empty($filter['max_price']))
        {
            $outputFilter['min_price'] = $filter['min_price'];
            $outputFilter['max_price'] = $filter['max_price'];
        }
        if(!empty($filter['rating']))
        {
            $outputFilter['rating'] =  $filter['rating'];
        }
        return $outputFilter;
    }

    /**
     * @param $filter
     * @param $products
     */
    protected function applyFilters($filter, $products)
    {
        if(!empty($filter['min_price']) && !empty($filter['max_price']))
        {
            $products->where([
                ['price', '>=', $filter['min_price']],
                ['price', '<=', $filter['max_price']]
            ]);
        }
        if(!empty($filter['rating']))
        {
            $products->where('review_total', '>=', $filter['rating']);
        }
    }
    /**
     * @param ParameterBag $params
     * @return array
     * @throws \Exception
     */
    public function actionBuy(ParameterBag $params)
    {
        /** @var Products $product */
        $product = $this->assertProductExists($params->product_id);
        $entityInput = $this->filter([
            'quantity' => 'int',
            'content_type' => 'str'
        ]);$errors = [];
        if(isset($_SESSION['user_id']))
        {

            $userId = BaseApp::visitor()->user_id;
            /** @var Carts $createCart */
            $createCart = $this->finder('App:Carts')
                ->where([
                    'user_id' => $userId,
                    'product_id' => $product->product_id
                ])->fetchOne();

            if(empty($createCart))
            {
                $createCart = $this->create('App:Carts');
                $createCart->user_id = $userId;
                $createCart->product_id = $product->product_id;
            }
            else
            {
                if($createCart->quantity >= $product->stock)
                {
                    $errors[] = 'Vous en commendez trop !';
                }
            }
            if(empty($errors))
            {
                $createCart->quantity = $createCart->quantity + $entityInput['quantity'];
                $createCart->save();
            }
        }
        else
        {
            $exist = false;
            $cartProductId = [];
            if(isset($_SESSION['cart_product_id']))
            {
                $cartProductId = $_SESSION['cart_product_id'];
                foreach ($cartProductId as $key => $cart)
                {
                    if($cart[0] == $product->product_id)
                    {
                        $exist = true;
                        $cartProductId[$key] = [
                            $product->product_id,
                            $cart[1] + $entityInput['quantity']
                        ];
                    }
                }
            }
            if($exist)
            {
                $_SESSION['cart_product_id'] = $cartProductId;
            }
            else
            {
                $_SESSION['cart_product_id'] = array_merge($cartProductId, [[$product->product_id, $entityInput['quantity']] ]);
            }
        }
        if($entityInput['content_type'] == 'shopping')
        {
            return $this->setErrorByFromByJason($errors, $this->app()->buildLink('Pub:carts'));
        }
        else
        {
            return $this->setErrorByFromByJason($errors, $this->app()->buildLink('Pub:product/categories', $product->Category));
        }

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
    protected function assertCategoryExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('App:Categories', $id, $with, $phraseKey);
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
}