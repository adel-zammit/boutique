<?php 
namespace Base;
class DataBase 
{
    protected $db;
    protected $statement;
    
    public function __construct()
    {
        $this->db = new \PDO('mysql:host=localhost;dbname=blog;','root', ''); #connexion à la base de donnée
    }

    /**
     * @param $request
     * @param array $args
     * @return bool|false|\PDOStatement
     */
    public function execute($request, array $args = [])
    {
        $db = $this->db;
        if(!empty($args)){
            $this->statement = $db->prepare($request);
            $this->statement->execute($args);
        }
        else
        {
            $this->statement = $db->query($request);
        }
        return $this->statement;
    }
    protected function isPost()
    {
        return (!empty($_POST));
    }
    protected function isGet()
    {
        return (!empty($_GET));
    }

    public function limit($query, $limit, $offset = 1,  $arg = [])
    {
        $offset = max(0, intval($offset));
        if($limit === null)
        {
            if(!$offset)
            {
                return $query;
            }
            $limit = 10000000000000;
        }
        $limit = max(1, intval($limit));
        return $this->execute("$query\nLIMIT $limit " . ($offset ? "OFFSET $offset" : ''), $arg);
    }
}