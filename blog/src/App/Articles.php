<?php
namespace App;

use Base\DataBase;

class articles extends DataBase
{
    public function getArticles()
    {
        if(!empty($_GET['categorie']))
        {
            //. ($this->isGet() ? ' OFFSET ' . ($_GET['start'] - 1) : '')
            return $this->limit('SELECT * FROM articles WHERE  id_categorie = ? ORDER BY date DESC', 1, ($this->isGet() && !empty( $_GET['start'])  ? $_GET['start'] - 1 : 0), [
                $_GET['categorie']
            ])->fetchAll(\PDO::FETCH_ASSOC);
        }
        else
        {
            return $this->limit('SELECT * FROM articles ORDER BY date DESC', 1, ($this->isGet() && !empty( $_GET['start']) ? $_GET['start'] - 1 : 0))->fetchAll(\PDO::FETCH_ASSOC);
        }
    }
    public function countArticle()
    {
        if(!empty($_GET['categorie']))
        {
            return $this->execute('SELECT count(*) as total FROM articles WHERE id_categorie = ?', [
                $_GET['categorie']
            ])->fetch(\PDO::FETCH_ASSOC);
        }
        else
        {
            return $this->execute('SELECT count(*) as total FROM articles ')->fetch(\PDO::FETCH_ASSOC);
        }
    }
    public function nouvel_article()
    {
        if($this->isPost())
        {
            var_dump($_SESSION);
            $article = $_POST['article'];
            $id_utilisateur = $_SESSION['id'];
            $id_categorie = $_POST['id_categorie'];
            if (empty($article) || empty($id_utilisateur) || empty($id_categorie)) { # Si jamais il manque un argument, la fonction ne s'exécute pas
                return "il manque un argument";
            }
            $this->execute("INSERT INTO articles(article, id_utilisateur, id_categorie, date) VALUES(?, ?, ?, CURRENT_TIMESTAMP())", [
                $article,
                $id_utilisateur,
                $id_categorie
           ]);
        }
        

        return false;
    }
    public function setNewCategory()
    {
        if($this->isPost())
        {
            $nom = $_POST['nom'];
            $this->execute("INSERT INTO categories(nom) VALUES(?)", [
                $nom
           ]);
        }
    }
    public function getCategories()
    {
        return $this->execute("SELECT * FROM categories")->fetchAll(\PDO::FETCH_ASSOC);
    }
}