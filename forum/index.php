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
	<div class=pres> 	
 <h2>Qu'est-ce qu'un forum ? </h2> 
<p> La définition d'un forum sur internet est simple : un forum de discussion est un espace en ligne dédié à l'échange d'informations et messages entre membres d'une communauté. 
	Soit un site web dédié aux discussions et échanges entre internautes. 
	Le forum peut laisser place à des discussions et échanges généralistes ou concerner un thème précis.
	Ainsi, il existe sur internet des forums traitant de tous les sujets possibles et imaginables : forum sur le sport, l'actualités, les divertissements, l'informatique, ... 
	Généralement, chaque forum est dédié à un thème précis. </p>  
</div> 



<section class=table> 
        <?php
        $topics = $DataBase->query("SELECT id_topics, auteur, titre, date FROM topics WHERE grade = 0 ORDER BY date DESC");
        if(!$DataBase->isMember())
        {
            $topics = $DataBase->query("SELECT id_topics, auteur, titre, date FROM topics WHERE grade <= 1 ORDER BY date DESC");
        }
        else if($DataBase->isModo())
        {
            $topics = $DataBase->query("SELECT id_topics, auteur, titre, date FROM topics WHERE grade <= 2 ORDER BY date DESC");
        }
        else if($DataBase->isAdmin())
        {
            $topics = $DataBase->query("SELECT id_topics, auteur, titre, date FROM topics WHERE grade <= 3 ORDER BY date DESC");
        }
        $topics = $topics->fetchAll(PDO::FETCH_ASSOC);

        if (empty($topics)) {
            echo 'Aucun topic';
        }
        else {
        ?>

        <table >
            <thead>
            <tr>
                <td>
                    Topics
                </td>
                <td>
                    Auteur
                </td>
                <td>
                    Date dernière réponse
                </td>
            </tr>
            </thead>
           <tbody>
           <?php foreach ($topics as $topic) { ?>
               <tr>
                   <td>
                       <a href="topic.php?id_topics=<?= $topic['id_topics'] ?>"><?= $topic['titre'] ?></a>
                   </td>
                   <td>
                       <?= $topic['auteur'] ?>
                   </td>
                   <td>
                       <?= $topic['date'] ?>
                   </td>
               </tr>
           <?php } ?>
           </tbody>
        </table>
    <?php } ?>
</section>
</main>
<footer>
    Copyright © 2020 All rights reserved
</footer>
</body>
</html>


