<?php
namespace App\Entity;

use Base\BaseApp;
use Base\Mvc\Entity\Entity;
use Base\Mvc\Entity\Structure;

/**
 * @property int coupon_id
 * @property string title
 * @property array category_ids
 * @property string code
 * @property string content_type
 * @property string coupon_type
 * @property float value
 * @property int start_date
 * @property int end_date
 * @property int coupon_date
 * @property float coupon_min
 */
class Coupon extends Entity
{
    /**
     * @param $price
     * @return float|int
     */
    public function getPrice($price)
    {
        if($this->coupon_type == 'percent')
        {
            return $price * (1 - ($this->value / 100));
        }
        else
        {
            return $price - $this->value;
        }
    }

    /**
     * @return string
     */
    public function getCouponPhrase()
    {
        if($this->coupon_type == 'percent')
        {
            return $this->value . '%';
        }
        else
        {
            return $this->value . ' Euro';
        }
    }

    /**
     * @param $price
     * @return float|int
     */
    public function getDiscount($price)
    {
        if($this->coupon_type == 'percent')
        {
            return ($price  * $this->value) / 100;
        }
        else
        {
            return $this->value;
        }
    }

    /**
     * @param Structure $structure
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'coupon';
        $structure->shortName = "App:Coupon";
        $structure->primaryKey = 'coupon_id';
        $structure->columns = [
            'coupon_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'title' => ['type' => self::STR],
            'category_ids' => ['type' => self::JSON_ARRAY, 'default' => []],
            'code' => ['type' => self::STR],
            'content_type' => ['type' => self::STR],
            'coupon_type' => ['type' => self::STR, 'default' => 'percent',
                'allowedValues' => ['percent', 'value']
            ],
            'value' => ['type' => self::FLOAT],
            'start_date' => ['type' => self::UINT, 'default' => BaseApp::time()],
            'end_date' => ['type' => self::UINT],
            'coupon_date' => ['type' => self::UINT, 'default' => BaseApp::time()],
            'coupon_min' => ['type' => self::FLOAT, 'default' => 0.00],
        ];

        return $structure;
    }
}