<!DOCTYPE html>
<html lang="fr">
<?php

include('classes/inscription.class.php');

/* Simple verification du mail et du pseudo */
if (isset($_POST['submit']) && $_POST['submit'] == 'S\'inscrire') {
    $inscription = new Inscription($_POST['date'], $_POST['mail'], $_POST['mdp'], $_POST['pseudo'], $_POST['prenom'], $_POST['nom'], $_POST['pays']);
    if ($inscription->checkEmail($_POST['mail']) == true) {
        if ($inscription->checkPseudo($_POST['pseudo'])) {
            $inscription->insert();
            $inscription->valide(' Votre inscription à bien été validé !');
        } else {
            $inscription->error('Ce pseudo est déja utiliser..');
        }
    } else {
        $inscription->error(' Ce mail est déja utilisé');
    }
}
?>

<head>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="styles/style_index.css">
    <meta charset="UTF-8">
    <title>Twitter</title>
</head>

<body>

    <div class="container register">
        <div class="row">
            <div class="col-md-3 register-left">
                <img src="./images/twitter.gif" alt="" />
                <h3>TwittHack</h3>
                <p>Partagez votre vie,<br>Élargissez votre cercle d'amis</p>
                <a href="page_connexion.php"><input type="button" name="submit" value="Se connecter" /></a><br />
            </div>

            <div class="col-md-9 register-right">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <h3 class="register-heading">Inscrivez-vous</h3>
                        <form action="" id="connexion" method="post">
                            <div class="row register-form">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="pseudo" id="pseudo" placeholder="Votre pseudo" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Votre prénom" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="nom" id="nom" placeholder="Votre nom" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="pays" id="pays" placeholder="Votre pays" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="date" class="form-control" name="date" id="date" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="mdp" id="mdp" placeholder="Mot de passe" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="mail" id="mail" placeholder="Votre mail" required />
                                    </div>
                                    <input type="submit" name="submit" class="btnRegister" value="S'inscrire" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>