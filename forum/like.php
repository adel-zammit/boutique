<?php
session_start();

$type = $_GET['type'];
$conn = new PDO("mysql:host=localhost;port=3306;dbname=forum;charset=UTF8", "root","");

$sujet = $conn->prepare('SELECT * FROM reponses  WHERE id = ?');
$sujet->execute([$_GET['id']]);
$sujet = $sujet->fetch();
if(empty($_SESSION['id']))
{
    header('location: sujet.php?id_sujets=' . $sujet['id_sujets']);
}
if(in_array($type, ['unlike', 'undislike']))
{
    $type = str_replace('un', '', $type);
    $prepare = $conn->prepare('DELETE FROM reaction WHERE content_type = ? AND message_id = ? AND user_id = ?');
    $prepare->execute([$type, $_GET['id'], $_SESSION['id']]);
    $count = $conn->prepare("UPDATE reponses set count = ?, count_dislike = ? WHERE id = ?");
    if($type == 'like')
    {
        $count->execute([$sujet['count'] - 1, $sujet['count_dislike'], $_GET['id']]);
    }
    else
    {
        $count->execute([$sujet['count'], $sujet['count_dislike'] - 1, $_GET['id']]);
    }
}
else
{
    $prepare = $conn->prepare('INSERT INTO reaction(content_type, message_id, user_id) value(?, ?, ?)');
    $prepare->execute([$type, $_GET['id'], $_SESSION['id']]);
    $count = $conn->prepare("UPDATE reponses set count = ?, count_dislike = ? WHERE id = ? ");
    if($type == 'like')
    {
        $count->execute([$sujet['count'] + 1, $sujet['count_dislike'], $_GET['id']]);
    }
    else
    {

        $count->execute([$sujet['count'], $sujet['count_dislike'] + 1, $_GET['id']]);
    }
}

header('location: sujet.php?id_sujets=' . $sujet['id_sujets']);