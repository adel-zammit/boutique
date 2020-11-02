<?php
if(!empty($_GET['id']) && !empty($_SESSION['id']))
{
    $conn = new PDO("mysql:host=localhost;port=3306;dbname=forum;charset=UTF8", "root","");

    $user = $conn->prepare("SELECT * FROM utilisateurs WHERE id = ?");
    $user->execute([$_SESSION['id'] ]);
    $user = $user->fetch(PDO::FETCH_ASSOC);
    $message = $conn->prepare('SELECT * FROM reponses WHERE id = ?');
    $message->execute([$_GET['id']]);
    $message = $message->fetch(PDO::FETCH_ASSOC);
    if($user['grade'] != 0)
    {
        header('location: sujet.php?id_sujets=' . $message['id_sujets']);
        return;
    }
    $delete = $conn->prepare('DELETE FROM reponses WHERE id = ?');
    $delete->execute([$_GET['id']]);
    header('location: sujet.php?id_sujets=' . $message['id_sujets']);
}
//header('location: index.php');