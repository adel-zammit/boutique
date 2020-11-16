<?php
namespace App\Entity;

use App\Pub\Controller\Product;
use Base\Mvc\Entity\Entity;
use Base\Mvc\Entity\Structure;

/**
 * @property int cart_id
 * @property int user_id
 * @property int product_id
 * @property int quantity
 *
 * Class Carts
 * @package App\Entity
 *
 * RELATION
 * @property User User
 * @property Products Product
 * @property Invoices Invoice
 */

class Carts extends Entity
{
    /**
     * @return float|int
     */
    public function getPrice()
    {
        return $this->Product->price * $this->quantity;
    }

    /**
     * @param Structure $structure
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'carts';
        $structure->shortName = "App:Carts";
        $structure->primaryKey = 'cart_id';
        $structure->columns = [
            'cart_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'user_id' => ['type' => self::UINT],
            'product_id' => ['type' => self::UINT],
            'quantity' => ['type' => self::UINT, 'default' => 0],
            'invoice_id' => ['type' => self::UINT, 'default' => 0],
        ];
        $structure->relations = [
            'User' => [
                'type' => self::TO_ONE,
                'entity' => 'App:User',
                'conditions' => 'user_id',
                'primary' => true
            ],
            'Product' => [
                'type' => self::TO_ONE,
                'entity' => 'App:Products',
                'conditions' => 'product_id',
                'primary' => true
            ],
            'Invoice' => [
                'type' => self::TO_ONE,
                'entity' => 'App:Invoices',
                'conditions' => 'invoice_id',
                'primary' => true
            ],
        ];
        return $structure;
    }
}