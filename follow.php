<?php
session_start();
var_dump($_POST);
try {
    $bdd = new PDO('mysql:dbname=common-database;host=localhost', 'root', 'root');
} catch (Exception $e) {
    die('Connexion échoué :' . $e->getMessage());
}
include('classes/profilMembre.class.php');
$user = new Membre($_SESSION['pseudo']);

$getProfilID = $bdd->prepare('select id from users where pseudo=?');
$getProfilID->execute(array($_POST['pseudo']));
$profilId = $getProfilID->fetch();


$profilId['id'] = strval($profilId['id']);

$follow = $user->follow($profilId['id']);