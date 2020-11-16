<?php
namespace App\Entity;

use Base\BaseApp;
use Base\Mvc\Entity\ArrayCollection;
use Base\Mvc\Entity\Entity;
use Base\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int category_id
 * @property string name
 * @property string description
 * @property int category_parent_id
 * @property string name_logo_category
 * @property int depth
 * @property int display_order
 *
 * Class Categories
 * @package App\Entity
 *
 * RELATIONS
 * @property Categories CategoryParent
 * @property ArrayCollection|Categories[] CategoryChild
 */
class Categories extends Entity
{
    /**
     * @return string
     */
    public function getUrlLogo()
    {
        return 'data/category_img/' . $this->category_id . '.jpg';
    }

    /**
     * @return string
     */
    public function getUrlLogoBypath()
    {
        return preg_replace('#\\\\#', '/', BaseApp::getRootDirectory()) . '/data/category_img/' . $this->category_id . '.jpg';
    }

    /**
     * @throws \Exception
     */
    protected function _postSave()
    {
        $CategoryParent = $this->CategoryChild;
        if($CategoryParent && $this->isUpdate())
        {
            foreach ($CategoryParent as $child)
            {
                $child->depth = $this->depth + 1;
                $child->save();
            }
        }
    }

    /**
     * @throws \Exception
     */
    protected function _postDelete()
    {
        $CategoryChild = $this->CategoryChild;
        if($CategoryChild)
        {
            foreach ($CategoryChild as $child)
            {
                $child->delete();
            }
        }
        unlink($this->getUrlLogo());
    }

    /**
     * @param Structure $structure
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'categories';
        $structure->shortName = "App:Categories";
        $structure->primaryKey = 'category_id';
        $structure->columns = [
            'category_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'name' => ['type' => self::STR],
            'description' => ['type' => self::STR, 'default' => ''],
            'category_parent_id' => ['type' => self::UINT],
            'name_logo_category' => ['type' => self::STR, 'default' => ''],
            'depth' => ['type' => self::UINT, 'default' => 0],
            'display_order' => ['type' => self::UINT, 'default' => 0],
        ];
        $structure->relations = [
            'CategoryParent' => [
                'type' => self::TO_ONE,
                'entity' => 'App:Categories',
                'conditions' => [['category_id', '=', '$category_parent_id']],
                'primary' => true
            ],
            'CategoryChild' => [
                'type' => self::TO_MANY,
                'entity' => 'App:Categories',
                'conditions' => [['category_parent_id', '=', '$category_id']],
            ]
        ];
        return $structure;
    }
}