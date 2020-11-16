
<?php 

include 'src/Base.php';
<form action="topic.php" method="post">
    <input type="text" name="article">
    <select name="id_categorie">
$article = new App\articles();
$article->nouvel_article();
?>
<form action="creer-article.php" method="post">
    <input type="text" name="article">
    <select name="id_categorie">
        <?php foreach($article->getCategories() as $category) { ?>
            <option value="<?= $category['id']  ?>"><?= $category['nom']  ?></option>
        <?php } ?>
    </select>
    <button type="submit"> submit</button>
</form>