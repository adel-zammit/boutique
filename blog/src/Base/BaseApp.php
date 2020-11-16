<?php 

class BaseApp 
{
    protected $db;
    protected $statement;
    
    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=blog;','root', ''); #connexion à la base de donnée
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
}