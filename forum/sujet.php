<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="index.css"/>
    <title>index</title>
</head>

<body>

<header class="topnav">
    <nav>
        <ul>
            <?php include('header.php') ?>
        </ul>
    </nav>
</header>
<main>

    <?php
    $sql = 'SELECT responses.*, responses.id as response_id, users.* FROM reponses as responses, utilisateurs as users WHERE responses.id_sujets = ? AND users.id = responses.auteur_id ORDER BY date DESC';
    $sql1 = 'SELECT titre FROM sujets WHERE id_sujets = ? ';
    $thread = $DataBase->query($sql1, [$_GET['id_sujets']])->fetch(PDO::FETCH_ASSOC);
    $responses = $DataBase->query($sql, [$_GET['id_sujets']])->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($_SESSION['id'])) {
        $user = $DataBase->query("SELECT * FROM utilisateurs WHERE id = ?", [
            $_SESSION['id']
        ])->fetch(PDO::FETCH_ASSOC);
    }
    if (empty($_GET['id_sujets'])) {
        echo '<section><p><a href="index.php"> Veuillez choisir un sujet.</a> </p></section>';
    } else {
        ?>


        <section><h1><?php echo $thread['titre']; ?></h1></section>


        <?php

        foreach ($responses as $response) {
            if (!empty($_SESSION['id'])) {
                $request = 'SELECT * FROM reaction WHERE message_id =? AND user_id = ? AND content_type = ?';
                $reactionLike = $DataBase->query($request, [
                    $response['response_id'],
                    $_SESSION['id'],
                    'like'
                ])->fetch();
                $reactionDislike = $DataBase->query($request, [
                    $response['response_id'],
                    $_SESSION['id'],
                    'dislike'
                ])->fetch();
            } else {
                $reactionLike = null;
                $reactionDislike = null;
            } ?>

            <div class='containe'>
                <?php
                if (!empty($_SESSION['id']) && $user['grade'] != 0) { ?>
                    <a href="delete.php?id=<?= $response['id']; ?>" class="button">Supprimer</a>
                <?php } ?>
                <p class='ido'><?php echo $response['login']; ?></p>
                <p class='text'><?php echo $response['message']; ?>    </p>
                <span class='tim'><?php echo $response['date']; ?></span>
                <?php
                if (!empty($_SESSION['id'])) {
                    if (!empty($reactionLike)) { ?>
                        <div><a href="like.php?id=<?= $response['response_id']; ?>&type=unlike">unlike
                                (<?= $response['count']; ?>)</a></div>
                    <?php } else { ?>
                        <div><a href="like.php?id=<?= $response['response_id']; ?>&type=like">J'AIME
                                (<?= $response['count']; ?>
                                )</a></div>
                    <?php }
                } ?>

                <?php
                if (!empty($_SESSION['id'])) {

                    if (!empty($reactionDislike)) { ?>
                        <div><a href="like.php?id=<?= $response['response_id']; ?>&type=undislike">undislike
                                (<?= $response['count_dislike']; ?>)</a></div>
                    <?php } else { ?>
                        <div><a href="like.php?id=<?= $response['response_id']; ?>&type=dislike">j'aime pas
                                (<?= $response['count_dislike']; ?>)</a></div>
                    <?php }
                } ?>
            </div>
            <?php
        }
    }
    ?>
    </article>
    <?php
    if (!empty($_SESSION['id'])) { ?>
        <article>
            <div class="titre">
                <form method="post">

                    <legend class='rep'>Poster un message</legend>
                    <label><?php echo $user['login']; ?></label>
                    <textarea name="message" placeholder="Poster un message"></textarea>
                    <input type="hidden" name="sujets" value="<?php echo $_GET['id_sujets']; ?>">
                    <input type="submit" name="submit" value="poster">
                </form>
            </div>
        </article>

        </section>
    <?php } ?>

    <?php

    if (isset($_POST['submit']) && isset($_SESSION['id'])) {
        $auteur = $user['id'];
        $message = $_POST['message'];
        $sujets = $_POST['sujets'];
        $connexion = mysqli_connect("localhost", "root", "", "forum");
        $sql = "INSERT INTO `reponses` (auteur_id, message, date, id_sujets) VALUES (?,?,CURRENT_TIMESTAMP(),?)";
        $DataBase->query($sql, [
            $auteur,
            $message,
            $sujets
        ]);
    }
    ?>
</main>

<footer>


</footer>
</body>
</html>