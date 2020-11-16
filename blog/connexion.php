<html>
<link rel="stylesheet" href="#"/>

<link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700&display=swap" rel="stylesheet">   
</html>
<head>

</head>


<div class="wrapper fadeInDown">
  <div id="formContent">

    <h2 class="active"> Connexion </h2>
   

    <div class="fadeIn first">
    </div>
    <?php

if(isset ($_POST['valider']))
{
    

    session_start();
    $db=mysqli_connect("localhost","root","","blog");
    $login=$_POST['login'];
    $password=$_POST['password'];
    $requete1="SELECT * FROM utilisateurs WHERE login='$login'and password='$password'";
    $query= mysqli_query ($db,$requete1);
    $resultat=mysqli_num_rows($query);

    
    
        if ($resultat==0){
        echo "Pseudo ou Mot de passe incorrect";
    }
    else
    {
        $_SESSION['message']="vous êtes connecté :)";

    $_SESSION['login']=$login;
    $_SESSION['id']= mysqli_fetch_assoc($query)['id'];
    $_SESSION['password']=$_POST['password'];
    header('location: index.php');
}

}















?>

    <form class="formulaire" name="inscription" method="post" action="connexion.php">
      <input type="text" placeholder= "Pseudo" required  name="login"/> <br/>
</br>
        <input type="password" placeholder= "Mot de passe" required  name="password"/> <br/>
 
        <input type="submit" class="fadeIn fourth" name="valider" value="Se Connecter"/>
    </form>

    </div>

  </div>
</div>



</div>
