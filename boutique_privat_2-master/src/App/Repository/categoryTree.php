<?php
namespace App\Repository;

use App\Entity\Categories;
use Base\Repository;

/**
 * Class categoryTree
 * @package App\Repository
 */
class categoryTree extends Repository
{
    /**
     * @return array
     */
    public function treeCategorySelect()
    {
        $output = [];
        if($this->tree())
        {
            foreach ($this->tree() as $category)
            {
                if ($category->depth)
                {
                    $prefix = str_repeat('--', $category->depth) . ' ';
                }
                else
                {
                    $prefix = '';
                }
                $output[$category->category_id] = [
                    'value' => $category->category_id,
                    'label' => $prefix . $category->name
                ];
            }
        }

        return $output;
    }

    /**
     * @param int $baseDepth
     * @param null $maxDepth
     * @return array
     */
    public function tree($baseDepth = 0, $maxDepth = null)
    {
        $categories = $this->categoryByDepth($baseDepth);
        return $this->treeCategory($categories, $output, $maxDepth);
    }

    /**
     * @param $categories
     * @param $output
     * @param null $maxDepth
     * @return array
     */
    public function treeCategory($categories, &$output, $maxDepth = null)
    {

        if($categories !== null)
        {
            foreach ($categories as $category)
            {
                $cats =
                    $this
                        ->finder('App:Categories')
                        ->where('category_parent_id', $category->category_id)
                        ->order('display_order')
                        ->fetch();

                if($maxDepth !== null)
                {
                    if($category->depth >= $maxDepth)
                    {
                        $output[] = $category;
                    }
                }
                else
                {
                    $output[] = $category;
                }
                $output =  $this->treeCategory($cats, $output, $maxDepth);
            }
        }
        return $output;
    }

    /**
     * @param int $baseDepth
     * @return array|mixed|null
     */
    public function categoryByDepth($baseDepth = 0)
    {
        return
            $this
                ->finder('App:Categories')
                ->where('depth', $baseDepth)
                ->order('display_order')
                ->fetch();
    }

    /**
     * @param $title
     * @return string|string[]
     */
    public function titleCategoryRemoveSpace($title)
    {
        return str_replace(' ', '-', $title);
    }

    /**
     * @param $category
     * @param $maxDepth
     * @return array
     */
    public function treeCategoryByExclude($category, $maxDepth  = null)
    {
        $tree = $this->treeCategory([$category], $output, $maxDepth);
        foreach ($tree as $categoryTree)
        {
            if($categoryTree->category_id != $category->category_id)
            {
                $output[] = $categoryTree;
            }
        }
        return $output;
    }

    /**
     * @param $categoriesChild
     * @param $id
     * @return bool
     */
    public function verifyParentId($categoriesChild, $id)
    {
        if($categoriesChild)
        {
            /** @var Categories $child */
            foreach ($categoriesChild as $child)
            {
                if($child->category_id === $id)
                {
                    return false;
                }
                return $this->verifyParentId($child->CategoryChild, $id);
            }
        }
        return true;
    }

}