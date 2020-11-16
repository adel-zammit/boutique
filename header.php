<?php session_start();
include 'connectbd.php';
include '../variables.php';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-165723247-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-165723247-1');
	</script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title><?php echo $Vtitre?></title>
	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<meta name="description" content="<?php echo $Vdesc?>" />
	<meta name="keywords" content="covid-19, protection, IDEL, Pernes les fontaines" />
	<?php if ($index=="non"){?>
	<meta name="robots" content="noindex, nofollow" />
	<?php }else{?>
	<meta name="robots" content="noindex, nofollow" />
	<?php }?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://blousesblanchesdepernes.fr/css/styleresponsive.css" rel="stylesheet" type="text/css" />
	<link href="https://blousesblanchesdepernes.fr/menu/style.css" rel="stylesheet" type="text/css" />
	<link rel="icon" type="type/png" href="https://blousesblanchesdepernes.fr/favicon.png" />
	<link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://blousesblanchesdepernes.fr/css/lightbox.css" type="text/css" media="screen" />
	<script src="https://blousesblanchesdepernes.fr/js/jquery-1.7.2.min.js"></script>
	<script src="https://blousesblanchesdepernes.fr/js/lightbox.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
</head>

<body>

<div id="wrapper1">

 <header id="banniere" role="banner">
    <a href="/index.php"><img src="https://blousesblanchesdepernes.fr/logos/logo-blouses-blanches-500px.jpg" alt="logo du site des blouses blanches de pernes" /></a>
    <div style="clear:both"></div>
 </header>
</div>

<div id="wrapper2">

  <nav id="navwrapper" role="navigation">
  
    <a class="toggleMenu" href="#">Menu</a>
	<div class="logo-facebook"><a href="https://fr-fr.facebook.com/Blouses-Blanches-de-Pernes-112829523746756/"  title="Suivez nous sur facebook"><img src="https://blousesblanchesdepernes.fr/images/picto-facebook.png" alt="logo facebook"></a></div>
     <ul class="nav">
		<li><a href="https://blousesblanchesdepernes.fr/index.php">Accueil</a></li>
        <li><a href="https://velo.blousesblanchesdepernes.fr/questionnaire/velo">Questionnaire vélo</a></li>
        <li><a href="https://blousesblanchesdepernes.fr/pompiers/pompiers.php">Infos Pompiers</a></li>
        <li><a href="https://blousesblanchesdepernes.fr/contacts-repertoire-actualise.php">Liste des professionnels de santé</a></li>
		<li><a href="https://blousesblanchesdepernes.fr/covid-19.php">Covid-19</a></li>
		<li><a href="https://blousesblanchesdepernes.fr/gardes-medicales.php">Gardes</a></li>
		<li><a href="https://blousesblanchesdepernes.fr/qui-sommes-nous.php">Qui sommes-nous ?</a></li>
		<li><a href="https://blousesblanchesdepernes.fr/soutien-des-enfants-au-personnel-soignant.php">Soutien des enfants pernois</a></li>
		<?php if (strtoupper($_SESSION['as_ident'])=='RA' || strtoupper($_SESSION['as_ident'])=='DC'){?>
			<li><a href="https://blousesblanchesdepernes.fr/interne/index.php">Interne</a></li>
		<?php }?>
    </ul>
	<?php if (strtoupper($_SESSION['as_ident'])=='PM' || strtoupper($_SESSION['as_ident'])=='RA' || strtoupper($_SESSION['as_ident'])=='DC'){?>
		<span class="vert"><a href="https://blousesblanchesdepernes.fr/deconnexion.php">Deconnexion</a></span>
	<?php }else{?>
		<span class="red"><a href="https://blousesblanchesdepernes.fr/connexion.php">Connexion</a></span>
	<?php }
	if (strtoupper($_SESSION['as_ident'])=='PM' || strtoupper($_SESSION['as_ident'])=='RA' || strtoupper($_SESSION['as_ident'])=='DC'){
		echo " | ";
		if ($_SESSION['secur']==1){
			echo "<span class='vert'><a href='https://blousesblanchesdepernes.fr/connexion-securise-mdp-change.php'>Modif mdp</a></span>";
		}else{
			echo "<span class='red'><a href='https://blousesblanchesdepernes.fr/connexion-securise.php'>Sécuriser votre connexion</a></span>";
		}
	}?>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="https://blousesblanchesdepernes.fr/menu/script.js"></script>
  </nav>
</div>
<?php if (strtoupper($_SESSION['as_ident'])=='PM' || strtoupper($_SESSION['as_ident'])=='RA' || strtoupper($_SESSION['as_ident'])=='DC'){?>
	<p style="color:#ffffff;">
		<?php echo "Bonjour ".$_SESSION['prenom']?><br />
	</p>
<?php }else{
	$_SESSION['as_ident']='';
	$_SESSION['prenom']='';
	$_SESSION['ident']='';
	header('Location: index.php');
}?>
