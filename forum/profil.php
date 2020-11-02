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

$connexion = mysqli_connect("localhost", "root","", "forum");
$requete = "SELECT * FROM utilisateurs";
$query = mysqli_query($connexion, $requete);
$resultat = mysqli_fetch_all($query);
$i = 0;

if( isset($_SESSION['login']) == true )
{
    foreach($resultat as $cle => $valeur) {
        $i += 1;
        if ( $i%2 == 1) {
            ?>
            <a href="user.php?id=<?php echo $resultat[$cle][0]; ?>"><section class="cmembre mimpair">
                <article class="pseudograde">
                    <p class="pseudo"><?php echo $resultat[$cle][1]; ?></p>
                    <?php
                        if ( $resultat[$cle][8] == 1 ) {
                        ?>
                        <p class="grade">Administrateur</p>
                        <?php
                        }
                        if ( $resultat[$cle][8] == 2 ) {
                        ?>
                        <p class="grade">Modérateur</p>
                        <?php
                        }
                        if ( $resultat[$cle][8] == 3 ) {
                        ?>
                        <p class="grade">Membre</p>
                        <?php
                        }
                    ?>
                </article>

            </section></a>
            <?php
        }
        else {
            ?>
            <a href="user.php?id=<?php echo $resultat[$cle][0]; ?>"><section class="cmembre mpair">
                <article class="pseudograde">
                    <p class="pseudo"><?php echo $resultat[$cle][1]; ?></p>
                    <?php
                        if ( $resultat[$cle][8] == 1 ) {
                        ?>
                        <p class="grade">Administrateur</p>
                        <?php
                        }
                        if ( $resultat[$cle][8] == 2 ) {
                        ?>
                        <p class="grade">Modérateur</p>
                        <?php
                        }
                        if ( $resultat[$cle][8] == 3 ) {
                        ?>
                        <p class="grade">Membre</p>
                        <?php
                        }
                    ?>
                </article>
                
            </section>
            </a>
            <?php
        }
    }
}
else
{
    echo "Vous n'avez pas accès à cette page";
}
?>


</main>
<footer>


	</footer>	
</body>
</html>
