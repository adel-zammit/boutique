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
            <?php include('header.php');
            if (!$DataBase->isAdmin()) {
                header('Location: index.php');
            }
            ?>
        </ul>
    </nav>
</header>

<main>
    <?php
    $topicId = $_GET['topic_id'];
    $sql2 = "SELECT * FROM topics WHERE id_topics = ?";
    $topic = $DataBase->query($sql2, [$topicId])->fetch(PDO::FETCH_ASSOC);
    if (isset($_POST["go"])) {
        $auteur = $login;
        $titre = $_POST["titre"];
        $grade = $_POST['grade'];
        $requete = "UPDATE topics SET titre= ?, grade = ? WHERE id_topics = ?";
        $DataBase->query($requete, [
            $titre,
            $grade,
            $topicId
        ]);
        header('location: nvxtopic.php');
    }
    ?>

    <section class="p-forum">
        <form action="nvxtopic_modif.php?topic_id=<?= $topicId ?>" method="post">
            <dl class="formRow">
                <dt>
                    <div class="block-form-label">
                        <label for="titre">Titre</label>
                    </div>
                </dt>
                <dd>
                    <input class="input" required type="text" name="titre" size="50" placeholder="titre" value="<?= $topic['titre'] ?>">
                </dd>
            </dl>
            <dl class="formRow">
                <dt>
                    <div class="block-form-label">
                        <label for="titre">Réserver</label>
                    </div>
                </dt>
                <dd>
                    <select name="grade" class="input">
                        <option value="0" <?= $topic['grade'] == 0 ? 'selected' : '' ?>>Public</option>
                        <option value="1" <?= $topic['grade'] == 1 ? 'selected' : '' ?>>Membre</option>
                        <option value="2" <?= $topic['grade'] == 2 ? 'selected' : '' ?>>Modérateur</option>
                        <option value="3" <?= $topic['grade'] == 3 ? 'selected' : '' ?>>Administrateur</option>
                    </select>
                </dd>
            </dl>
            <div class="p-submit">
                <button type="submit" class="button" name="go"  value="Poster">Poster</button>
            </div>
        </form>
    </section>

</main>
<footer>


</footer>
</body>
</html>



