<?php
namespace App\Entity;

use Base\BaseApp;
use Base\Mvc\Entity\Entity;
use Base\Mvc\Entity\Structure;

/**
 * @property int product_img_id
 * @property string name
 * @property int product_id
 *
 * Class ProductImg
 * @package App\Entity
 *
 * RELATION
 * @property Products Product
 */
class ProductImg extends Entity
{
    /**
     * @return string
     */
    public function getUrlLogo()
    {
        return 'data/product_img/' . $this->product_img_id . '.jpg';
    }

    /**
     * @return string
     */
    public function getUrlLogoBypath()
    {
        return (\Base\BaseApp::getBaseLink() != '/' ? \Base\BaseApp::getBaseLink() : '/') . 'data/product_img/' . $this->product_img_id . '.jpg';
    }

    /**
     *
     */
    protected function _postDelete()
    {
        unlink('data/product_img/' . $this->product_img_id . '.jpg');
    }

    /**
     * @param Structure $structure
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'product_img';
        $structure->shortName = "App:ProductImg";
        $structure->primaryKey = 'product_img_id';
        $structure->columns = [
            'product_img_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'name' => ['type' => self::STR, 'default' => ''],
            'product_id' => ['type' => self::UINT],
        ];
        $structure->relations = [
            'Product' => [
                'type' => self::TO_ONE,
                'entity' => 'App:Products',
                'conditions' => 'product_id',
                'primary' => true
            ]
        ];
        return $structure;
    }
}