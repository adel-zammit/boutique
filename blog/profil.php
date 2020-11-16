<html>
<link rel="stylesheet" href="#"/>

<a href="https://dribbble.com/shots/10683714-50-Buttons-For-Figma-Community" target="_blank">

<header>
<?php
include("header.php")
?>
</header>
<div class="nav">
				<button class="droite"><a href="index.php">Acceuil</a></button>
				<button class="droite"><a href="profil.php">Editer Profil</a></button>
				<button class="droite"><a href="deconnexion.php">Deconexion</a></button>
            </div>  



    <h2> Modifiez votre profil </h2>




<form class="formulaire" name="modifier" method="post" action="profil.php">
	 </br>
Votre Pseudo: <input type="text" name="login" value="<?php echo $_SESSION ['login'];?>">

        
         </br>
        
        Entrez votre mot de passe: <input type="password" name="password" value="<?php echo $_SESSION['password'];?>">
     </br>
      
        confirmez votre mot de passe : <input type="password" name="password1"value="<?php
        echo $_SESSION['password'];?>"><br/>
         </br>
        <input type="submit" name="valider" value="Valider"/>
</form>
<?php

if(isset($_POST['valider']))
{
    

 $db=mysqli_connect("localhost","root","","blog");
 $newlogin= $_POST['login']; 
 $login= $_SESSION['login']; 
 $password=$_POST['password'];

 $req= "UPDATE utilisateurs SET login = '".$newlogin."', password = '".$password."' WHERE login= '".$login."' ";
 $query= mysqli_query ($db, $req);
 $_SESSION['login']=$newlogin;
 $_SESSION['password']=$password;
 header('location: index.php');
 
}

?>

</body>
</html>