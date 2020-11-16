<!DOCTYPE html>
<html lang="fr">

<head>

<link rel="stylesheet" href="#" type="text/css" >

</head>
<body>

<?php

//SI ON CLIC SUR BOUTON SUBMIT{
    if(isset($_POST['bouton'])){

        //DEFINITION DES VARIABLES PAR INPUT
        $login=$_POST['login'];

        $password=$_POST['password'];
        $conf_password=$_POST['conf_password'];
        $email=$_POST['email'];
        //SI MES VARIABLES SONT BIEN RENTREES{
            if($login && $password && $conf_password)
                {
                //SI LE MOT DE PASSE = MA CONFIRMATION DE MOT DE PASSE{
                    if($password == $conf_password){
                        //CONNEXION BDD 
                        $db = mysqli_connect("localhost", "root", "", "blog");
                        //CREATION REQUETE
                        $requete="INSERT INTO utilisateurs (login,password,email,id_droit) VALUES ('$login','$password','$email',1)";
                        var_dump($requete);
                        var_dump($db);
                        //EXECUTION REQUETE
                        $resultat=mysqli_query($db,$requete);
                        //REDIRECTION PAGE
                        // header('Location: index.php');
                        // }SINON
                    }else{ 
                        echo 'Mot de passe et confirmation de Mot de Pass ne correspondent pas.';}
                    
                    //}SINON
                }else{
                    echo 'Veuillez remplire correctement tout les champs.';}
                //}
            }
        
    ?>

<header> 

<h1>Inscription</h1>
</header>

    <form method="POST" action="inscription.php">


        <fieldset>
            <legend><strong>Inscription</strong></legend>
            
            <label for="fname">Login: (Obligatoire)</label><br>
            <input type="text"  name="login"><br>

            <br><label for="mail">Password: (Obligatoire)</label>
            <br><input type="password" name="password"></br>

            <br><label for="num">Confirmation Password:</label>
            <br><input type="password" name="conf_password"></br>

            <br><label for="email">Email: (Obligatoire)</label></br>   
            <input type="email" name="email"><br>



        </fieldset>
     
        <br>
       
        <br><input type="submit" value="Inscription" name="bouton"></br>
        
    </div>
</div>

</form>
</body>
</html>