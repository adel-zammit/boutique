<?php
session_start()
?>
    
    <html>
        <head>
            <meta charset="utf-8">
            <!-- importer le fichier de style -->
            <link rel="stylesheet" href="style.css" type="text/css" >
        </head>
        
        <nav class="navbar navbar-expand-lg navbar-light bg-light" id="nav">
            <a class="navbar-brand" href="index.php" title ="Retour à l'accueil">Le Prog<span class="titre">'Blog</span></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
                            <header>

                            <body>
        <div id="container">
               <?php
 
 if(isset($_SESSION['id'])){


?>

<h2>Vous etes connecter.</h2>
                <button class="droite"><a href="deconnexion.php">Se déconnecter</a></button>
             </div> 
                 <button><a href="profil.php" class="button">Editer Profil</a>

                <?php
             }else{ 
                ?>

            <button class="droite"><a href="index.php" class="button">S'inscrire</a></button>
            <button class="droite"><a href="connexion.php" class="button">Se connecter</a></button>
            <select name="categorie" id="categorie">
            <option value="">Selectionner une catégorie</option>
            <option value="-">#</option>
            <option value="-">#</option>
            <option value="-">#</option>
            </select>
            
                <?php
                 }
                ?>

        </div>
    </body>
</html>