<html>
<link rel="stylesheet" href="#"/>


<header>
    <?php
    include("header.php");
    if(!$DataBase->isAdmin())
    {
        header('location: index.php');
    }
    $user = $DataBase->query('SELECT * FROM utilisateurs WHERE id = ?', [$_GET['user_id']])->fetch(PDO::FETCH_ASSOC);
    ?>
</header>
<div class="nav">
    <button class="droite"><a href="index.php">Acceuil</a></button>
    <button class="droite"><a href="profil.php">Editer Profil</a></button>
    <button class="droite"><a href="deconnexion.php">Deconexion</a></button>
</div>


<h2> Modifiez votre profil </h2>


<form class="formulaire" name="modifier" method="post" action="admin_modif_user.php?user_id=<?= $_GET['user_id'] ?>">
    </br>
    Votre Pseudo: <input type="text" name="login" value="<?php echo $user ['login']; ?>">


    </br>
    Email : <input type="text" name="email" value="<?php echo $user ['email']; ?>">


    </br>


    </br>

    <label for="grade">Choisir un Grade : </label>
    <select name="grade" id="grade">
        <option value="0" <?= $user['grade'] == 0 ? 'selected' : '' ?>>utilisateur</option>
        <option value="1" <?= $user['grade'] == 1 ? 'selected' : '' ?> >moderateur</option>
        <option value="2" <?= $user['grade'] == 2 ? 'selected' : '' ?>>admin</option>
    </select>


    <input type="submit" name="valider" value="Valider"/>
</form>

<?php


if (isset($_POST['valider'])) {
    $newlogin = $_POST['login'];
    $email = $_POST['email'];
    $grade = $_POST['grade'];
    $req = "UPDATE utilisateurs SET login = ?, email = ?, grade = ? WHERE id = ? ";
    $DataBase->query($req, [
        $newlogin,
        $email,
        $grade,
        $_GET['user_id']
    ]);
}

?>

</body>
</html>