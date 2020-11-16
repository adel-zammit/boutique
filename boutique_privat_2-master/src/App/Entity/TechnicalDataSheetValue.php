<?php
namespace App\Entity;

use Base\Mvc\Entity\Entity;
use Base\Mvc\Entity\Structure;

/**
 * @property int value_id
 * @property int product_id
 * @property int technical_data_sheet_id
 * @property string value
 *
 * Class TechnicalDataSheetValue
 * @package App\Entity
 *
 * RELATION
 * @property Products Product
 * @property TechnicalDataSheet TechnicalDataSheet
 */
class TechnicalDataSheetValue extends Entity
{

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'technical_data_sheet_value';
        $structure->shortName = "App:TechnicalDataSheetValue";
        $structure->primaryKey = 'value_id';
        $structure->columns = [
            'value_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'product_id' => ['type' => self::UINT],
            'technical_data_sheet_id' => ['type' => self::UINT],
            'value' => ['type' => self::STR]
        ];
        $structure->relations = [
            'Product' => [
                'type' => self::TO_ONE,
                'entity' => 'App:Products',
                'conditions' => 'product_id',
                'primary' => true
            ],
            'TechnicalDataSheet' => [
                'type' => self::TO_ONE,
                'entity' => 'App:TechnicalDataSheet',
                'conditions' => 'technical_data_sheet_id',
                'primary' => true
            ]
        ];
        return $structure;
    }
}