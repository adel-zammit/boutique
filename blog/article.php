<?php
include 'src/Base.php';
$article = new App\articles();
// $article->nouvel_article('$article', 1,1);
foreach($article->getArticles() as $articleValue)
{
    var_dump($articleValue);
}

 ?>