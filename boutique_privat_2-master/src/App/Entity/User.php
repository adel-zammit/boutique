<?php
namespace App\Entity;

use Base\Mvc\Entity\Entity;
use Base\Mvc\Entity\Structure;

/**
 * @property int user_id
 * @property string username
 * @property string password
 * @property string email
 * @property bool is_admin
 */
class User extends Entity
{
    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->is_admin;
    }

    /**
     * @param Structure $structure
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'user';
        $structure->shortName = 'App:User';
        $structure->primaryKey = 'user_id';
        $structure->columns = [
            'user_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'username' => ['type' => self::STR],
            'password' => ['type' => self::STR],
            'email' => ['type' => self::STR],
            'is_admin' => ['type' => self::BOOL, 'default' => 0],
        ];

        return $structure;
    }
}