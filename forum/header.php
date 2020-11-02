<?php
session_start();
include 'src/DataBase.php';
$DataBase = new DataBase();
if (isset($_SESSION['login'])):
	?>

    <head>
        <link
                rel="stylesheet"
                href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
        />
    </head>



<div class=connect>
    
<li><a href="index.php">Acceuil</a></li>
 <li><a href="topic.php">topic</a></li>


 
 <?php echo'  
 <li><a href="profil.php?id=' , $_SESSION['id'] , '">profil</a></li>'
?>   
<li>
        <form action="index.php" method="post">
            <input type="submit" name='deconnexion' class="deco" value="deconnexion">
        </form>

    </div>

<?php if (isset($_POST['deconnexion'])) {
                session_unset();
                session_destroy();
                header('Location:index.php');
            }
            ?></li>


 <?php else:?>     
 <div class="connect">

    <li><a href="index.php">Acceuil</a></li>
 <li><a href="inscription.php">Inscription</a></li>
 <li><a href="connexion.php">Connexion</a></li>
 <li><a href="topic.php">topic</a></li>
</div>


<?php endif;?>

<!--<div><a href="like.php?id=--><?php //echo $donnees['id']; ?><!--&u=--><?php //echo $userinfo['id']; ?><!--">J'AIME</a></div>-->