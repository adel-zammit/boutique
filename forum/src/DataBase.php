<?php

/**
 * Class DataBase
 */
class DataBase
{
    /**
     * @var PDO
     */
    protected $db;

    /**
     * @var array
     */
    protected $user = [];

    /**
     * DataBase constructor.
     */
    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;port=3306;dbname=forum', 'root', '');
    }

    /**
     * @param $request
     * @param array $arg
     * @return bool|false|PDOStatement
     */
    public function query($request, array $arg = [])
    {
        $db = $this->db;
        if (!empty($arg))
        {
            $statement = $db->prepare($request);
            $statement->execute($arg);
        }
        else
        {
            $statement = $db->query($request);
        }
        return $statement;
    }

    /**
     * @return array|bool|false|PDOStatement
     */
    public function getUser()
    {
        if(!empty($_SESSION['id']))
        {
            if(empty($this->user))
            {
                $this->user = $this->query('SELECT * FROM utilisateurs WHERE id = ?', [$_SESSION['id']]);
                $this->user = $this->user->fetch(PDO::FETCH_ASSOC);
            }
            return $this->user;
        }
        return [];
    }

    /**
     * @return bool
     */
    public function isMember()
    {
        $user = $this->getUser();
        if(empty($user))
        {
            return false;
        }
        if($this->isAdmin() || $this->isModo())
        {
            return true;
        }
        if($user['grade'] != 0)
        {
            return false;
        }
        return true;
    }

    /**
     * @return bool
     */
    public function isModo()
    {
        $user = $this->getUser();
        if(empty($user))
        {
            return false;
        }
        if($user['grade'] != 1)
        {
            return false;
        }
        return true;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        $user = $this->getUser();
        if(empty($user))
        {
            return false;
        }
        if($user['grade'] != 2)
        {
            return false;
        }
        return true;
    }
}
