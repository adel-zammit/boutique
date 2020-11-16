<?php


namespace App\Entity;

use Base\Mvc\Entity\Entity;
use Base\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int cron_id
 * @property string title
 * @property string description
 * @property string cron_exe
 * @property int last_exe
 */
class Cron extends Entity
{
    /**
     * @param Structure $structure
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'cron';
        $structure->shortName = 'App:Cron';
        $structure->primaryKey = 'cron_id';
        $structure->columns = [
            'cron_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'title' => ['type' => self::STR],
            'description' => ['type' => self::STR],
            'cron_exe' => ['type' => self::STR],
            'last_exe' => ['type' => self::UINT, 'default' => time()]
        ];


        return $structure;
    }
}