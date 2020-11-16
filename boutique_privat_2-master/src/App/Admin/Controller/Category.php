<?php


namespace App\Admin\Controller;


use App\Entity\Categories;
use App\Entity\TechnicalDataSheet;
use App\Repository\categoryTree;
use Base\Mvc\ParameterBag;
use Base\Repository;

/**
 * Class Category
 * @package App\Admin\Controller
 */
class Category extends AbstractController
{

    /**
     * @var string[]
     */
    protected $extensionType = ['.jpeg', '.png', '.jpg'];

    /**
     *
     */
    public function actionIndex()
    {
        $viewParams = [
            'categoryTree' => $this->getRepoCategoryTree()->tree()
        ];
        $this->view('category_list', $viewParams);
    }

    /**
     * @param Categories $category
     */
    protected function addEditCategory(Categories $category)
    {
        $viewParams = [
            'category' => $category,
            'treeCategory' => $this->getRepoCategoryTree()->treeCategorySelect()
        ];
        $this->view('category_edit', $viewParams);
    }

    public function actionAdd()
    {
        $category = $this->create('App:Categories');
        $this->addEditCategory($category);
    }

    public function actionEdit(ParameterBag $params)
    {
        $category = $this->assertCategoryExists($params->category_id);
        $this->addEditCategory($category);
    }

    protected function saveCategoryProcess(Categories $category)
    {
        $entityInput = $this->filter([
            'name' => 'str',
            'description' => 'str',
            'category_parent_id' => 'int',
            'display_order' => 'int',
        ]);
        $errors = [];
        if(empty($entityInput['name']))
        {
            $errors[] = $this->BaseApp()->phrase('please_enter_value_for_required_field_x', ['field' => 'name']);
        }
        $checkAvatar = $this->checkLogo();
        if(($checkAvatar['error'] && $category->isInsert()) || ($checkAvatar['error'] && !empty($_FILES["logo_category"]["name"])))
        {
            $errors[] = $checkAvatar['error'];
        }
        if($category->isUpdate())
        {
            if($category->category_id == $entityInput['category_parent_id'])
            {
                $errors[] = 'dddd';
            }
            elseif(!$this->getRepoCategoryTree()->verifyParentId($category->CategoryChild, $entityInput['category_parent_id']))
            {
                $errors[] = 'dddd';
            }
        }
        if(empty($errors))
        {
            /** @var Categories $parentId */
            $parentId = $this->BaseApp()->find('App:Categories', $entityInput['category_parent_id']);
            $category->name = $entityInput['name'];
            $category->description = $entityInput['description'];
            $category->category_parent_id = $entityInput['category_parent_id'];
            $category->depth = !empty($parentId) ? $parentId->depth + 1 : 0;
            $category->display_order = $entityInput['display_order'];
            $category->save();
            $this->setLogo($category);
        }
        return $this->setErrorByFromByJason($errors, $this->app()->buildLink('admin:category'));
    }

    /**
     * @param ParameterBag $params
     * @return array|\Base\Reply\Redirect|string[]
     * @throws \Exception
     */
    public function actionDelete(ParameterBag $params)
    {
        /** @var Categories $category */
        $category = $this->assertCategoryExists($params->category_id);
        if($this->isPost())
        {
            $category->delete();
            return $this->redirect($this->app()->buildLink('admin:category'));
        }
        else
        {
            $title = $category->name;
            $linkEdit = $this->app()->buildLink('admin:category/edit', $category);
            $linkDeleted = $this->app()->buildLink('admin:category/delete', $category);
            return $this->Delete($linkEdit, $linkDeleted, $title);
        }
    }

    /**
     * @param ParameterBag $params
     * @return array
     * @throws \Exception
     */
    public function actionSave(ParameterBag $params)
    {
        if($params->category_id)
        {
            $category = $this->assertCategoryExists($params->category_id);
        }
        else
        {
            $category = $this->create('App:Categories');
        }
        return $this->saveCategoryProcess($category);
    }

    /**
     * @return array
     */
    public function checkLogo()
    {
        $type = pathinfo($_FILES["logo_category"]["name"], PATHINFO_EXTENSION);
        $output = [
            'type' => $type
        ];
        if (!in_array("." . $type, $this->extensionType)) {
            $output['error'] = "Format d'image autorisé: " . implode(", ", $this->extensionType);
        }
        return $output;
    }

    /**
     * @param Categories $category
     * @throws \Exception
     */
    public function setLogo(Categories $category)
    {
        $pathAvatar = 'data/category_img/';
        $name = $category->category_id . ".jpg";
        foreach (scandir($pathAvatar) as $avatar) {
            if (pathinfo($avatar, PATHINFO_FILENAME) == pathinfo($name, PATHINFO_FILENAME)) {
                $path = $pathAvatar . $avatar;
                unset($path);
            }
        }
        move_uploaded_file($_FILES["logo_category"]["tmp_name"], $pathAvatar . $name);
        $category->name_logo_category = $_FILES["logo_category"]["name"];
        $category->save();
    }

    /**
     *
     */
    public function actionTechnicalDataSheet()
    {
        $infos = $this->getRepoTechnicalDataSheet()->getFind();
        $viewParams = [
            'infos' => $infos
        ];
        $this->view('technical_data_sheet', $viewParams);
    }

    /**
     * @param TechnicalDataSheet $TechnicalDataSheet
     * @return array
     */
    protected function AddEditTechnicalDataSheet(TechnicalDataSheet $TechnicalDataSheet)
    {
        $categories = $this->getRepoCategoryTree()->treeCategorySelect();
        $output = [];
        foreach ($categories as $categorySelect)
        {
            $output[$categorySelect['value']] =  [
                'selected' =>  ($categorySelect['value'] == $TechnicalDataSheet->category_id),
                'label' => $categorySelect['label']
            ];
        }
        $params = [
            'namePage' => 'dd',
            'saveURL' => $this->app()->buildLink('admin:category/technical-data-sheet/save' , $TechnicalDataSheet),
            'nameButton' => 'Save',
            'logoButton' => 'far fa-save',
            'ajax' => true,
            'Input' => [
                'title' => [
                    'type' => 'textbox',
                    'value' => $TechnicalDataSheet->title ? $TechnicalDataSheet->title : '' ,
                    'required' => true,
                    'title' => 'Nom',
                    'description' => ""
                ],
                'category_id' => [
                    'type' => 'selector',
                    'value' => '',
                    'title' => 'Category',
                    'description' => "",
                    'options' => $output
                ],
            ]
        ];
        return $this->formAjax($params);
    }

    /**
     * @return array
     */
    public function actionTechnicalDataSheetAdd()
    {
        $TechnicalDataSheet = $this->create('App:TechnicalDataSheet');
        return $this->AddEditTechnicalDataSheet($TechnicalDataSheet);
    }

    /**
     * @param ParameterBag $params
     * @return array
     * @throws \Exception
     */
    public function actionTechnicalDataSheetEdit(ParameterBag $params)
    {
        /** @var TechnicalDataSheet $technicalDataSheet */
        $technicalDataSheet = $this->assertTechnicalDataSheetExists($params->technical_data_sheet_id);;
        return $this->AddEditTechnicalDataSheet($technicalDataSheet);
    }

    /**
     * @param TechnicalDataSheet $technicalDataSheet
     * @return array
     * @throws \Exception
     */
    protected function saveTechnicalDataSheetProcess(TechnicalDataSheet $technicalDataSheet)
    {
        $entityInput = $this->filter([
            'title' => 'str',
            'category_id' => 'int'
        ]);
        $errors = [];
        if(empty($entityInput['title']))
        {
            $errors[] = 'Il faut un titre';
        }
        if(empty($entityInput['category_id']))
        {
            $errors[] = 'Il faut selectione une category';
        }
        if(empty($errors))
        {
            $technicalDataSheet->title = $entityInput['title'];
            $technicalDataSheet->category_id = $entityInput['category_id'];
            $technicalDataSheet->save();
        }
        return $this->setErrorByFromByJason($errors, $this->app()->buildLink('admin:category/technical-data-sheet'));
    }

    /**
     * @param ParameterBag $params
     * @return array
     * @throws \Exception
     */
    public function actionTechnicalDataSheetSave(ParameterBag $params)
    {
        if($params->technical_data_sheet_id)
        {
            /** @var TechnicalDataSheet $technicalDataSheet */
            $technicalDataSheet = $this->assertTechnicalDataSheetExists($params->technical_data_sheet_id);
        }
        else
        {
            /** @var TechnicalDataSheet $technicalDataSheet */
            $technicalDataSheet = $this->create('App:TechnicalDataSheet');
        }

        return $this->saveTechnicalDataSheetProcess($technicalDataSheet);
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
    protected function assertTechnicalDataSheetExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('App:TechnicalDataSheet', $id, $with, $phraseKey);
    }

    /**
     * @return categoryTree|Repository
     */
    protected function getRepoCategoryTree()
    {
        return $this->repository('App:categoryTree');
    }

    /**
     * @return \App\Repository\TechnicalDataSheet|Repository
     */
    protected function getRepoTechnicalDataSheet()
    {
        return $this->repository('App:TechnicalDataSheet');
    }
}