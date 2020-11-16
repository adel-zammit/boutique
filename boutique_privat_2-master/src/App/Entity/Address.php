<?php
namespace App\Entity;

use Base\BaseApp;
use Base\Mvc\Entity\Entity;
use Base\Mvc\Entity\Structure;

/**
 * @property int address_id
 * @property int name
 * @property int user_id
 * @property string sex
 * @property string first_name
 * @property string last_name
 * @property string address
 * @property string additional_address
 * @property string country_code
 * @property int zip_code
 * @property string city
 * @property string cell_phone
 * @property string landline_phone
 *
 * Class Address
 * @package App\Entity
 *
 * RELATION
 * @property User User
 * @property Country Country
 */
class Address extends Entity
{

    /**
     * @param Structure $structure
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'address';
        $structure->shortName = "App:Address";
        $structure->primaryKey = 'address_id';
        $structure->columns = [
            'address_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'name' => ['type' => self::STR],
            'user_id' =>  ['type' => self::UINT],
            'sex' => ['type' => self::STR, 'default' => 'm',
                'allowedValues' => ['m', 'mme']
            ],
            'first_name' => ['type' => self::STR],
            'last_name' => ['type' => self::STR],
            'address' => ['type' => self::STR],
            'additional_address' =>  ['type' => self::STR],
            'country_code' =>  ['type' => self::STR],
            'zip_code'  =>  ['type' => self::UINT],
            'city' => ['type' => self::STR],
            'cell_phone' => ['type' => self::STR],
            'landline_phone' => ['type' => self::STR],
        ];

        $structure->relations = [
            'User' => [
                'type' => self::TO_ONE,
                'entity' => 'App:User',
                'conditions' => 'user_id',
                'primary' => true
            ],
            'Country' => [
                'type' => self::TO_ONE,
                'entity' => 'App:Country',
                'conditions' => 'country_code',
            ]
        ];
        return $structure;
    }
}