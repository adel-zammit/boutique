<?php


namespace App\Entity;

use Base\BaseApp;
use Base\Mvc\Entity\Entity;
use Base\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int country_code
 * @property string name
 * @property string native_name
 * @property string iso_code
 * @property float sales_tax_rate
 */
class Country extends Entity
{
    /**
     * @param $price
     * @return float|int
     */
    public function getPrice($price)
    {
        if($this->sales_tax_rate > 0.000)
        {
            return $price * ( 1 + ($this->sales_tax_rate / 100));
        }
        if($this->sales_tax_rate == 0.000)
        {
            return  $price;
        }
        return $price  * ( 1 + (BaseApp::getConfigOptions()->defaultSaleTaxRate / 100));
    }

    /**
     * @param Structure $structure
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'country';
        $structure->shortName = 'App:Country';
        $structure->primaryKey = 'country_code';
        $structure->columns = [
            'country_code' => ['type' => self::STR],
            'name' => ['type' => self::STR],
            'native_name' => ['type' => self::STR],
            'iso_code' => ['type' => self::STR],
            'sales_tax_rate' => ['type' => self::FLOAT, 'default' => -0.001]
        ];


        return $structure;
    }
}