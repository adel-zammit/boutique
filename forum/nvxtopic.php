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
    $login = $_SESSION['login'];
    $sql2 = "SELECT * FROM topics ";
    $topics = $DataBase->query($sql2)->fetchAll(PDO::FETCH_ASSOC);
    if (isset($_POST["go"])) {
        $auteur = $login;
        $titre = $_POST["titre"];
        $requete = "INSERT INTO `topics` (`auteur`, `titre`, `date`, grade) VALUES (?,?, CURRENT_TIMESTAMP(), ?)";
        $DataBase->query($requete, [
            $auteur,
            $titre,
            $_POST['grade']
        ]);
        header('location: nvxtopic.php');
    }
    ?>
    <div class="table">

        <table>
            <thead>
            <tr>
                <th>Id</th>
                <th>auteur</th>
                <th>titre</th>
                <th>date</th>
                <th>grade</th>
                <th>Edit</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($topics as $topic) { ?>
                <tr>
                    <th>
                        <?= $topic['id_topics'] ?>
                    </th>
                    <th>
                        <?= $topic['auteur'] ?>
                    </th>
                    <th>
                        <?= $topic['titre'] ?>
                    </th>
                    <th>
                        <?= $topic['date'] ?>
                    </th>
                    <th>
                        <?php
                        switch ($topic['grade'])
                        {
                            case 0:
                                echo "Public";
                                break;
                            case 1:
                                echo "Membre";
                                break;
                            case 2:
                                echo "Modérateur";
                                break;
                            case 3:
                                echo "Administrateur";
                                break;
                        }
                        ?>
                    </th>
                    <th>
                        <a href="nvxtopic_modif.php?topic_id=<?= $topic['id_topics'] ?>">Edit</a>
                    </th>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

    <section class="p-forum">
        <form method="post">
            <dl class="formRow">
                <dt>
                    <div class="block-form-label">
                        <label for="titre">Titre</label>
                    </div>
                </dt>
                <dd>
                    <input class="input" required type="text" name="titre" size="50" placeholder="titre">
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
                        <option value="0">Public</option>
                        <option value="1">Membre</option>
                        <option value="2">Modérateur</option>
                        <option value="3">Administrateur</option>
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



