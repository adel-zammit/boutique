<?php
include 'src/Base.php';
$article = new App\articles();
?>

<!DOCTYPE html>

<html>
<head>
    <title>Articles - Blog</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="articles">
        <?php foreach($article->getArticles() as $artcileValue) { ?>
            <div class="article">
                <?= $artcileValue['article'] ?>
            </div>
        <?php } ?>
    </div>
    <?php $pageNav = new Base\PageNav; 
    
    if(!empty($_GET['categorie']))
    {
        $data = [
            'dataName' => 'categorie',
            'value' => $_GET['categorie']
        ];
    }
    else
    {
        $data = [
            'dataName' => '',
            'value' => 0
        ];
    }
    ?>

    <?= $pageNav->getNave(
        [
            'data' => $data,
            'link' => 'articles.php', 
            'total' => $article->countArticle()['total'], 
            'perPage' => 1,
            'nameGet' => 'start', 
            'page' => (!empty($_GET['start']) ? $_GET['start'] : 0 )]); ?>
</body>
</html>