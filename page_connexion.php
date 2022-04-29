<?php
include('classes/login.class.php');

session_start();
session_destroy();
session_unset();

if (isset($_POST['submit']) && $_POST['submit'] == "Se connecter") {

  $log = new login($_POST['mail'], $_POST['mdp']);
  if ($log->checkAccount()) {
    session_start();
    $info = $log->getInfo($_POST['mail']);  
    $_SESSION['login'] = $_POST['mail'];
    $_SESSION['mdp'] = $_POST['mdp'];                   /* Si la verification = true j'initialise mail mdp id et je redirige */
    $_SESSION['id'] = $info['id'];
    $_SESSION['pseudo'] = $info['pseudo'];
    header('location:home.php');
  } else {
    $log->error('Adresse mail ou mot de passe incorrecte');
  }
}

?>
<!DOCTYPE html>

<head>

  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="https://kit.fontawesome.com/9b3172f124.js"></script>

  <link rel="stylesheet" type="text/css" href="styles/style_index.css">
  <meta charset="UTF-8">
  <title>Tweeter</title>
</head>

<body>

  <div class="container register">
    <div class="row">
      <div class="col-md-3 register-left">
        <img src="./images/twitter.gif" alt="" />
        <h3>TwittHack</h3>
        <p>Partagez votre vie,<br>Élargissez votre cercle d'amis</p>
        <a href="index.php"><input type="button" name="submit" value="S'inscrire" /></a><br />
      </div>
      <div class="col-md-9 register-right">
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <h3 class="register-heading">Connectez-vous</h3>
            <div class="row register-form">
              <div class="col-md-6">
                <form action="" id="connexion" method="post">

                  <div class="form-group">
                    <input type="email" class="form-control" name="mail" id="mail" placeholder="Votre mail" required />
                  </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input type="password" class="form-control" name="mdp" id="mdp" placeholder="Mot de passe" required />
                </div>
                <input type="submit" name="submit" class="btnRegister" value="Se connecter" />
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>