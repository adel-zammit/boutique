<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="index.css"/>
    <title>connexion</title>
</head>

<header class="topnav">

    <nav>
        <ul>
            <?php include('header.php') ?>
        </ul>
    </nav>
</header>

<?php

if (isset($_SESSION['login'])) {
    header('Location: index.php');
}
?>

<section>
    <article class="box">
        <form class="formu" method="post">
            <legend class=co>Connexion</legend>
            <label for="pseudo">Pseudo :</label>
            <input type="text" name="login" placeholder="login" required/>
            <label for="password">Mot de Passe :</label>
            <input type="password" name="pass" placeholder="mot de passe" required/>
            <input type="submit" value="Connexion" name="Connexion" required/>
        </form>
    </article>
</section>
</main>

<?php

if (isset($_POST["Connexion"])) {

    $login = $_POST["login"];
    $password = $_POST["pass"];
    $requete = "SELECT * FROM utilisateurs WHERE login = ?";
    $resultat = $DataBase->query($requete, [$login]);
    $resultat = $resultat->fetch(PDO::FETCH_ASSOC);
    if (!empty($resultat)) {
        if (password_verify($password, $resultat['password'])) {

            $_SESSION['id'] = $resultat['id'];
            $_SESSION['login'] = $resultat['login'];
            header('Location: index.php');

        } else {
            echo '*Mot de passe ou login incorrect';

        }

    }
}

?>

<footer>

    Copyright © 2020 All rights reserved
</footer>
</body>
</html>