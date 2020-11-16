<?php
namespace App\Entity;

use Base\BaseApp;
use Base\Mvc\Entity\Entity;
use Base\Mvc\Entity\Structure;

/**
 * @property int coupon_log_id
 * @property int coupon_id
 * @property string coupon_name
 * @property string coupon_code
 * @property float total_price
 * @property float price
 * @property int user_id
 * @property string username
 * @property int invoice_id
 * @property float coupon_value
 * @property string coupon_type
 * @property int coupon_date
 * @property float coupon_min
 *
 * Class CouponLog
 * @package App\Entity
 *
 * RELATION
 * @property User User
 * @property Invoices Invoice
 * @property Coupon Coupon
 */

class CouponLog extends Entity
{
    /**
     * @return float|int
     */
    public function getDiscount()
    {
        if($this->coupon_type == 'percent')
        {
            return ($this->total_price  * $this->coupon_value) / 100;
        }
        else
        {
            return $this->coupon_value;
        }
    }

    /**
     * @param Structure $structure
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'coupon_log';
        $structure->shortName = "App:CouponLog";
        $structure->primaryKey = 'coupon_log_id';
        $structure->columns = [
            'coupon_log_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'coupon_id' => ['type' => self::UINT],
            'coupon_name' => ['type' => self::STR],
            'coupon_code' => ['type' => self::STR],
            'total_price' => ['type' => self::FLOAT],
            'price' => ['type' => self::FLOAT],
            'user_id' => ['type' => self::UINT],
            'username' => ['type' => self::STR],
            'invoice_id' => ['type' => self::UINT],
            'coupon_value' => ['type' => self::FLOAT],
            'coupon_type' => ['type' => self::STR, 'default' => 'percent',
                'allowedValues' => ['percent', 'value']
            ],
            'coupon_date' => ['type' => self::INT, 'default' => \Base\BaseApp::time() ],
            'coupon_min' => ['type' => self::FLOAT, 'default' => 0.00],
        ];
        $structure->relations = [
            'User' => [
                'type' => self::TO_ONE,
                'entity' => 'App:User',
                'conditions' => 'user_id',
                'primary' => true
            ],
            'Invoice' => [
                'type' => self::TO_ONE,
                'entity' => 'App:Invoices',
                'conditions' => 'invoice_id',
                'primary' => true
            ],
            'Coupon' => [
                'type' => self::TO_ONE,
                'entity' => 'App:Coupon',
                'conditions' => 'coupon_id',
                'primary' => true
            ]
        ];
        return $structure;
    }
}