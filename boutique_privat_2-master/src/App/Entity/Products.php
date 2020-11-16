<?php
namespace App\Entity;

use Base\BaseApp;
use Base\Mvc\Entity\ArrayCollection;
use Base\Mvc\Entity\Entity;
use Base\Mvc\Entity\Structure;

/**
 * @property int product_id
 * @property string title
 * @property string description
 * @property float price
 * @property int category_id
 * @property int product_date
 * @property int icon_date
 * @property int stock
 * @property float review_total
 *
 *
 * Class Products
 * @package App\Entity
 *
 * RELATION
 * @property ArrayCollection|ProductImg[] ProductImg
 * @property ArrayCollection|TechnicalDataSheetValue[] TechnicalDataSheetValues
 * @property Categories Category
 * @property ArrayCollection|Review[] Review
 */
class Products extends Entity
{
    /**
     * @return string
     */
    public function getUrlBypath()
    {
        return (\Base\BaseApp::getBaseLink() != '/' ? \Base\BaseApp::getBaseLink() : '/') . 'data/product_img_default/' . $this->product_id . '.jpg';
    }

    /**
     * @return string
     */
    public function getAlt()
    {
        return $this->title;
    }

    /**
     * @throws \Exception
     */
    public function rebuildRating()
    {
        $review = $this->getDb()->execute('SELECT SUM(rating) AS sum, COUNT(*) AS total FROM review WHERE product_id = ?', [
            $this->product_id
        ])->fetch();
        $this->review_total = (float)$review['sum'] / $review['total'];
        $this->save();
    }

    /**
     * @throws \Exception
     */
    public function moveProduct()
    {
        $db = $this->getDb();
        $db->delete('technical_data_sheet_value', 'product_id = ?', [$this->product_id]);
        $technicalDataSheet = $this->finder('App:TechnicalDataSheet')
            ->where('category_id', $this->category_id)
            ->fetch();
        /** @var TechnicalDataSheet $technicalData */
        foreach ($technicalDataSheet as $technicalData)
        {
            /** @var TechnicalDataSheetValue $TechnicalDataSheetCreate */
            $TechnicalDataSheetCreate = BaseApp::create('App:TechnicalDataSheetValue');
            $TechnicalDataSheetCreate->product_id = $this->product_id;
            $TechnicalDataSheetCreate->technical_data_sheet_id = $technicalData->technical_data_sheet_id;
            $TechnicalDataSheetCreate->value = '';
            $TechnicalDataSheetCreate->save();
        }
    }

    /**
     *
     */
    protected function _postDelete()
    {
        $db = $this->getDb();
        unlink('data/product_img_default/' . $this->product_id . '.jpg');
        $productImgs = $this->ProductImg;
        foreach ($productImgs as $productImg)
        {
            $productImg->delete();
        }
        $db->delete('review', 'product_id = ?', [$this->product_id]);
        $db->delete('technical_data_sheet_value', 'product_id = ?', [$this->product_id]);
    }

    /**
     * @param Structure $structure
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'products';
        $structure->shortName = "App:Products";
        $structure->primaryKey = 'product_id';
        $structure->columns = [
            'product_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'title' => ['type' => self::STR],
            'description' => ['type' => self::STR],
            'price' => ['type' => self::FLOAT],
            'category_id' => ['type' => self::UINT],
            'product_date' =>  ['type' => self::UINT, 'default' => BaseApp::time()],
            'icon_date'  =>  ['type' => self::UINT, 'default' => 0],
            'stock' => ['type' => self::UINT, 'default' => 0],
            'review_total' => ['type' => self::FLOAT, 'default' => 0],
        ];
        $structure->relations = [
            'ProductImg' => [
                'type' => self::TO_MANY,
                'entity' => 'App:ProductImg',
                'conditions' => 'product_id',
            ],
            'TechnicalDataSheetValues' => [
                'type' => self::TO_MANY,
                'entity' => 'App:TechnicalDataSheetValue',
                'conditions' => 'product_id',
            ],
            'Category' => [
                'type' => self::TO_ONE,
                'entity' => 'App:Categories',
                'conditions' => 'category_id',
                'primary' => true
            ],
            'Review' => [
                'type' => self::TO_MANY,
                'entity' => 'App:Review',
                'conditions' => 'product_id',
                'order' => 'review_date'
            ]
        ];
        return $structure;
    }
}