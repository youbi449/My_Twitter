<?php
session_start();
include('classes/tweet.class.php');
$user = new tweet($_SESSION['id']);

if (($_FILES['photo']['name'] != "")) {
    $user->storeImg($_POST['tweet'], $_FILES['photo']['name']);
} else {
    $user->addTweet($_POST['tweet']);
}

 header('location:home.php');   
