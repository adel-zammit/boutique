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
 

if(empty($_GET['id_topics']))
{
    echo'<section><p><a href="index.php"> Veuillez choisir un topic.</a> </p></section>';
}
else {
$connexion = mysqli_connect("localhost", "root", "", "forum");
$sql1 = 'SELECT * FROM topics WHERE id_topics="'.$_GET['id_topics'].'"';
$req1 = mysqli_query($connexion,$sql1);		
$dataa = mysqli_fetch_array($req1);
    ?>
    <section>
        <h1>
            <article><?php echo $dataa['titre']; ?></article>
         </h1> 
         <h3> 
                 <aside><?php echo $dataa['auteur']; ?></aside>
         </h3> 
    </section>

	<table width="500" border="1"><tr>
	<td>
	Sujets  
	</td><td>
	Auteur
	</td><td>
    description
	</td><td>
	Date dernière réponse
	</td></tr>
    <?php
       $connexion = mysqli_connect("localhost", "root", "", "forum");
       $sql = 'SELECT * FROM sujets  WHERE id_topics="'.$_GET['id_topics'].'" ORDER BY date DESC';
       $req = mysqli_query($connexion,$sql);
	while ($data = mysqli_fetch_array($req)) {

	echo '<tr>';
	echo '<td>';
	echo '<a href="sujet.php?id_sujets=' , $data['id_sujets'] , '">' ,$data['titre'] , '</a>';
	echo '</td><td>';
	echo $data['auteur'];
    echo '</td><td>';
	echo $data['description'];
	echo '</td><td>';
    echo $data['date'];
    

    }
	     
    	?>
     </td></tr></table>

 
	<?php
  echo '<p><a href="nvxsujet.php?id_topics=' , $_GET['id_topics'] , '"> Creer sujet</a>  ' ;                 
               

}

	
?>
</section>
</main>
<footer>


	</footer>	
</body>
</html>



