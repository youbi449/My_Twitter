<?php
session_start();
var_dump($_GET);
try {
    $bdd = new PDO('mysql:dbname=common_database;host=localhost', 'root', '');
} catch (Exception $e) {
    die('Connexion échoué :' . $e->getMessage());
}

require_once 'classes/tweet.class.php';

$like = new tweet($_SESSION['id']);

$like->addLike($_SESSION['id'],$_GET['tweet']);

header('location:home.php');