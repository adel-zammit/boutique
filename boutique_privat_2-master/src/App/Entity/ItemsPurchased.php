<?php
namespace App\Entity;

use Base\Mvc\Entity\Entity;
use Base\Mvc\Entity\Structure;

/**
 * @property int purchased_id
 * @property int invoice_id
 * @property int user_id
 * @property int product_id
 * @property int quantity
 *
 * Class ItemsPurchased
 * @package App\Entity
 *
 * RELATION
 * @property User User
 * @property Products Product
 * @property Invoices Invoice
 */
class ItemsPurchased extends Entity
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
        $structure->table = 'items_purchased';
        $structure->shortName = "App:ItemsPurchased";
        $structure->primaryKey = 'purchased_id';
        $structure->columns = [
            'purchased_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'invoice_id' => ['type' => self::UINT],
            'user_id' => ['type' => self::UINT],
            'product_id' => ['type' => self::UINT],
            'quantity' => ['type' => self::UINT],
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
            ]
        ];
        return $structure;
    }
}