<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="index.css"/>
    <title>Inscription</title>
</head>
<body>
<header>
    <nav>
        <ul>

            <?php include('header.php');
            if (isset($_SESSION['login']) || isset($_SESSION['passe'])) {
                header('Location: index.php');
            }
            ?>
        </ul>
    </nav>
</header>

<main>
    <div>
        <form action="inscription.php" method="post">
            <fieldset class=inscrip>
                <legend>Identifiants</legend>
                <input type="text" name="login" maxlength="8" required placeholder="login"/>
                <input type="password" name="passe" minlength="4" required placeholder="password"/>
                <input type="password" minlength="4" name="passe2" required placeholder="confirmation"/>
            </fieldset>

            <fieldset class=inscrip>
                <legend> Infos personelles</legend>
                <input type="text" name="nom" placeholder='nom'>
                <input type="text" name="prenom" placeholder='prenom'>
                <P>Sexe : <label>Homme </label>
                    <input type="radio" name="sex" value="Homme">
                    <label>Femme </label>
                    <input type="radio" name="sex" value="Femme"></p>
                <input type="email" name="email" size="30" placeholder="toto@exemple.com">
                <input type="text" name="localisation" placeholder='localisation'>
            </fieldset>


            <label><input type="checkbox" name="condition" required placeholder="condition"/> <a href="">J'accepte les
                    conditions générales d'utilisation.</a></label>
            <input type="submit" value="inscription" name="inscription"/>
        </form>
    </div>

    <section>

        <?php
        if (isset($_POST["inscription"])) {
            $login = $_POST['login'];
            {
                $sql = "SELECT * FROM utilisateurs WHERE login='$login'";
                $req2 = $DataBase->query($sql);
                $req2 = $req2->fetch();
                if (($_POST['passe'] != $_POST['passe2'])) {
                    echo "<p>Mots de passes rentrés différents</p>";

                } else if ($req2) {
                    echo "*Login existant";
                } else {
                    $login = $_POST["login"];
                    $hash = password_hash($_POST['passe'], PASSWORD_BCRYPT, ['cost' => 15]);
                    $nom = $_POST["nom"];
                    $prenom = $_POST["prenom"];
                    $sexe = $_POST["sex"];
                    $email = $_POST["email"];
                    $localisation = $_POST["localisation"];
                    $pass2 = $_POST["passe2"];
                    $requete = "INSERT INTO utilisateurs (login, password, nom, prenom, sexe, email, localisation, grade) values (?,?,?,?,?,?,?,?)";
                    $DataBase->query($requete, [
                        $login,
                        $hash,
                        $nom,
                        $prenom,
                        $sexe,
                        $email,
                        $localisation,
                        0
                    ]);
                }
            }
        }
        ?>

</main>

<footer>

    Copyright © 2020 All rights reserved
</footer>
</body>
</html>		