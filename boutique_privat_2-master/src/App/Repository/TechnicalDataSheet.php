<?php
namespace App\Repository;

use App\Entity\Categories;
use Base\BaseApp;
use Base\Repository;

/**
 * Class categoryTree
 * @package App\Repository
 */
class TechnicalDataSheet extends Repository
{
    public function getFind()
    {
        $categories = $this->getRepoCategoryTree()->tree();
        $output = [

        ];
        foreach ($categories as $category)
        {
            $output[] = [
                'category' => $category,
                'find' => $this->finder('App:TechnicalDataSheet')
                    ->where('category_id', $category->category_id)->fetch()
            ];
        }
        return $output;
    }

    /**
     * @return categoryTree|Repository
     */
    protected function getRepoCategoryTree()
    {
        return BaseApp::repository('App:categoryTree');
    }
}