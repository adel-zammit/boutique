<?php
namespace App\Entity;

use Base\BaseApp;
use Base\Mvc\Entity\Entity;
use Base\Mvc\Entity\Structure;

/**
 * @property int review_id
 * @property int user_id
 * @property string username
 * @property int rating
 * @property string review
 * @property int product_id
 * @property int review_date
 *
 * Class Review
 * @package App\Entity
 *
 * RELATION
 * @property User User
 * @property Products Product
 */
class Review extends Entity
{
    /**
     * @param Structure $structure
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'review';
        $structure->shortName = "App:Review";
        $structure->primaryKey = 'review_id';
        $structure->columns = [
            'review_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'user_id' => ['type' => self::UINT],
            'username' =>  ['type' => self::STR],
            'rating' => ['type' => self::UINT],
            'review' =>  ['type' => self::STR],
            'product_id' => ['type' => self::UINT],
            'review_date' => ['type' => self::UINT, 'default' => BaseApp::time()],
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

        ];
        return $structure;
    }
}