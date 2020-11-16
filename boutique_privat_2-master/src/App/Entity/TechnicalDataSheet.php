<?php
namespace App\Entity;

use Base\Mvc\Entity\Entity;
use Base\Mvc\Entity\Structure;

/**
 * @property int technical_data_sheet_id
 * @property int category_id
 * @property string title
 *
 * Class TechnicalDataSheet
 * @package App\Entity
 *
 * RELATION
 * @property Categories Category
 */
class TechnicalDataSheet extends Entity
{
    /**
     * @param Structure $structure
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'technical_data_sheet';
        $structure->shortName = "App:TechnicalDataSheet";
        $structure->primaryKey = 'technical_data_sheet_id';
        $structure->columns = [
            'technical_data_sheet_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'category_id' => ['type' => self::UINT],
            'title' => ['type' => self::STR]
        ];
        $structure->relations = [
            'Category' => [
                'type' => self::TO_ONE,
                'entity' => 'App:Categories',
                'conditions' => 'category_id',
                'primary' => true
            ]
        ];
        return $structure;
    }
}