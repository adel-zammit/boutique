<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="index.css"/>
    <title>index</title>
</head>
<body>
<header>
    <nav>
        <ul>
            <?php include('header.php')
            ?>
        </ul>
    </nav>
</header>

<main>
    <section>
        <form method="post">
            <?php
            if (isset($_SESSION['login']))
            {
            $login = $_SESSION['login'];
            $sql2 = "SELECT * FROM utilisateurs WHERE login = ?";
            $req2 = $DataBase->query($sql2, [$login]);


            ?>


            <input disabled type="text" value=<?php echo $login; ?>  name="auteur">
            <input required placeholder="Titre" type="text" maxlength="12" name="titre" size="50">
            <textarea required placeholder="Votre message" minlength="8" maxlength="60" name="message"></textarea>
            <input type="hidden" name="topic" value="<?php echo $_GET['id_topics']; ?>">
            <input type="submit" name="go" value="Poster">
        </form>

        <?php


            if (isset($_POST["go"])) {
                $auteur = $login;
                $titre = $_POST["titre"];
                $message = $_POST["message"];
                $sql = "INSERT INTO `sujets` (auteur, titre, description, date, id_topics) VALUES (?, ?, ?,CURRENT_TIMESTAMP(),?)";
                $DataBase->query($sql, [
                    $auteur,
                    $titre,
                    $message,
                    $_POST['topic']
                ]);
                echo '<a href="topic.php?id_topics=', $_GET['id_topics'], '">Revenir en arriere </a>';

            }
        }

        else {
            echo "<p> Connectez vous pour avoir accé(e) a cette page </p>";
        }

        ?>
    </section>
</main>
<footer>


</footer>
</body>
</html>