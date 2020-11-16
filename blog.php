<?php
session_start();
ob_start();
$cnx = mysqli_connect("localhost", "root", "", "blog");

if ( isset($_GET["idarticle"]) ) {
    $idarticle = $_GET["idarticle"];
    $intidarticle = intval($idarticle);
    $requete1 = "SELECT * FROM commentaires WHERE id_article=$intidarticle ORDER BY date ASC";
    $query1 = mysqli_query($cnx, $requete1);
    $resultat = mysqli_fetch_all($query1, MYSQLI_ASSOC);
    $taille = sizeof($resultat) - 1;
    $requetearticle = "SELECT * FROM articles WHERE id=$intidarticle";
    $queryarticle = mysqli_query($cnx, $requetearticle);
    $resultatarticle = mysqli_fetch_all($queryarticle, MYSQLI_ASSOC);
}

if ( isset($_SESSION['login']) ) {
    $requete2 = "SELECT * FROM utilisateurs WHERE login='".$_SESSION['login']."'";
    $query2 = mysqli_query($cnx, $requete2);
    $resultat2 = mysqli_fetch_all($query2, MYSQLI_ASSOC);
}
else {
    header("Location: connexion.php");
}

date_default_timezone_set('Europe/Paris');
$is2car = false;

if ( isset($_POST['envoyer']) == true && isset($_POST['commentaire']) && strlen($_POST['commentaire']) >= 2 ) {
    $msg = $_POST['commentaire'];
    $remsg = addslashes($msg);
    $requete2 = "INSERT INTO commentaires (commentaire, id_article, id_utilisateur, date) VALUES ('$remsg', '$intidarticle', ".$resultat2[0]['id'].", '".date("Y-m-d H:i:s")."')";
    $query2 = mysqli_query($cnx, $requete2);
    header("Location: article.php?idarticle=$intidarticle");
    }
    elseif ( isset($_POST['envoyer']) == true && isset($_POST['commentaire']) && strlen($_POST['commentaire']) < 2 ) {
        $is2car = true;
    }
?>

<!DOCTYPE html>

<html>

<head>
    <title>Blog - Message</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
<?php include("header.php"); ?>
    <main class="mainarticles">
        <?php if ( isset($_GET["idarticle"]) ) {?>
         <section class="cmid">
            <section class="articlepart">
            <h1><?php echo $resultatarticle[0]["titre"]; ?></h1>
            <p class="h1topic"><?php echo nl2br($resultatarticle[0]['article']); ?></p>
            </section>
            <section class="articlepart">
            <?php
            $a = 0;
            if( !empty($resultat) && isset($_GET["idarticle"]) ) {
            while ($a <= $taille) {
                $datesql = $resultat[$a]['date'];
                $newdate = date('d-m-Y à H:i:s', strtotime($datesql));
                $iduser = $resultat[$a]['id_utilisateur'];
                $idcom = $resultat[$a]['id'];
                $intidcom = intval($idcom);
                $requetelogin = "SELECT login, email, id_droits FROM utilisateurs WHERE id=$iduser";
                $querylogin = mysqli_query($cnx, $requetelogin);
                $resultatlogin = mysqli_fetch_all($querylogin, MYSQLI_ASSOC);

                include("like.php"); // SYSTEME DE LIKE/DISLIKE
                ?>
                <section class="cmessages">
                    <article class="messageleft">
                        <h2><?php echo $resultatlogin[0]["login"]; ?></h2>
                    </article>
                    <article class="message">
                        <article>
                        <?php
                        echo "le <i><u>".$newdate."</u></i><br /><br />";
                        echo $resultat[$a]['commentaire']."<br />";
                        ?>
                        </article>
                        <section>
                            <article class="likebtn">
                                <form method="post" action="article.php?idarticle=<?php echo $intidarticle; ?>">
                                    <div id="formvote">
                                    <?php
                                    if ( isset($_SESSION['login']) && $resultat3[0]['COUNT(*)'] != "0" ) {
                                        echo "<input type=\"submit\" name=\"likebutton".$a."\" id=\"likev\" value=\"like\" required><div class=\"resultatvotes\">".$resultat5[0]['COUNT(*)']."</div>";
                                        echo "<input type=\"submit\" name=\"dislikebutton".$a."\" id=\"dislike\" value=\"dislike\" required><div class=\"resultatvotes\">".$resultat6[0]['COUNT(*)']."</div>";
                                    }
                                    elseif ( isset($_SESSION['login']) && $resultat4[0]['COUNT(*)'] != "0" ) {
                                        echo "<input type=\"submit\" name=\"likebutton".$a."\" id=\"like\" value=\"like\" required><div class=\"resultatvotes\">".$resultat5[0]['COUNT(*)']."</div>";
                                        echo "<input type=\"submit\" name=\"dislikebutton".$a."\" id=\"dislikev\" value=\"dislike\" required><div class=\"resultatvotes\">".$resultat6[0]['COUNT(*)']."</div>";
                                    }
                                    else {
                                        echo "<input type=\"submit\" name=\"likebutton".$a."\" id=\"like\" value=\"like\" required><div class=\"resultatvotes\">".$resultat5[0]['COUNT(*)']."</div>";
                                        echo "<input type=\"submit\" name=\"dislikebutton".$a."\" id=\"dislike\" value=\"dislike\" required><div class=\"resultatvotes\">".$resultat6[0]['COUNT(*)']."</div>";
                                    }
                                    ?>
                                    </div>
                                </form>
                            </article>
                        </section>
                    </article>
                </section>
                <?php
                $a++;
            }
        }
        elseif ( isset($_GET["idaritlce"]) && empty($resultatarticle) || isset($_SESSION['login']) && !isset($_GET["idarticle"]) ) {
            echo "Cet Article n'existe pas !";
        }
        elseif ( isset($_GET["idarticle"]) && !empty($resultatarticle) && empty($resultat) ) {
            echo "Pas de commentaire pour cet article, envoyez votre premier message !";
        }
            ?>
            </section>
            <section class="articlepart">
            <?php
           
            if ( isset($_SESSION['login']) && isset($_GET["idarticle"]) && !empty($resultatarticle) ) {
            ?>
                <form class="form_site" method="post" action="article.php?idarticle=<?php echo $intidarticle; ?>">
                    <label>VOTRE MESSAGE</label>
                    <textarea name="commentaire" required></textarea><br />
                    <input type="submit" value="Envoyer" name="envoyer" >
                </form>
                <?php
                if ( $is2car == true ) {
                ?>
                    <p>Votre message doit comporter au moins 2 caractères.</p>
                <?php
                }
            }

            elseif ( !isset($_SESSION['login']) ) {
            ?>
                <p class="red center">ERREUR</b><br />
                Vous devez être connecté pour accéder à cette page.</p>
            <?php
            }
            ?>
            </section>
           </section>
        <section>
     </section>

    <?php 
    if ( $_SESSION['droits'] == 1337 ) {
    ?>
    <form action="article.php?idarticle=<?php echo $intidarticle; ?>" method="post">
    <label for="editarticle">Edit Article:</label>
    <textarea id="edit" name="editarticle"><?php echo $resultatarticle[0]['article']; ?></textarea>
    <input type="submit" name="edita" value="Edit">
    </form>
    <?php
    }
    if (isset($_POST["edita"])) {
       $edited = $_POST["editarticle"];
       $editrequete = "UPDATE articles SET article = '$edited' WHERE id = $intidarticle";
       $queryedit = mysqli_query($cnx, $editrequete);
       header("Location:article.php?idarticle=$intidarticle");
    }
}
else {
    echo "<span class=\"red center\">Erreur 404, article introuvable.</span>";
}
    ?>
    </main>
<?php include("footer.php"); 
mysqli_close($cnx);
ob_end_flush();
?>
</body>

</html>