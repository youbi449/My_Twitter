<?php
session_start();

require_once 'classes/tweet.class.php';

$like = new tweet($_SESSION['id']);
?>

<b>Front work in progress ! ! </b> <br>
Liste des utilisateurs ayant liker ce tweet: <br>
<?php
$like->getUserWhoLike($_GET['id_tweet']);





