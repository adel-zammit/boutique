<?php 
include 'src/Base.php';
$article = new App\articles();
$article->setNewCategory();
?>

<form action="admin.php" method="post">
<input type="text" name="nom" >
<button type="submit"> submit</button>
</form>