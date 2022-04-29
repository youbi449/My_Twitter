<?php

include('connexionbdd.class.php');

class option
{
    private $mail;
    private $pseudo;
    private $motDePass;
    protected $connexion;
    protected $bdd;

    public function __construct()
    {
        $this->connexion = new Connexion();
        $this->bdd = $this->connexion->getDB();
    }

    public function changePseudo()
    {
        if (isset($_POST['subPseudo'])) {
            $newPseudo = $_POST['changePseudo'];
            $mail2 = $_SESSION['login'];
            if (($newPseudo != '')) {
                        $sql = "UPDATE users SET pseudo = '$newPseudo' WHERE mail = '$mail2'";
                        $stmt = $this->bdd->prepare($sql);
                        $stmt->execute();
                        $_SESSION['pseudo'] = $newPseudo;
                        echo 'Votre pseudo a bien été modifié !';
            }
        }
    }

    public function changeMDP(){
        if(isset($_POST['subMDP'])) {
                $this->motDePass = $_POST['currentMDP'];
                $newpassword = $_POST['newMDP'];
                $verifmdp = $_POST['changeMDP'];
                $mail2 = $_SESSION['login'];
                $newpassword = hash_hmac('ripemd160', $newpassword, 'vive le projet tweet_academy');
            if (($this->motDePass != '') && ($newpassword != '') && ($verifmdp != '')) {
                    if ($newpassword == $verifmdp) {
                        $sql = "UPDATE users SET password ='$newpassword' WHERE mail = '$mail2'";
                        $stmt = $this->bdd->prepare($sql);
                        $stmt->execute();
                        $_SESSION['mdp'] = $newpassword;
                        echo 'Votre mot de passe a bien été modifié !';
                    }
            }
        }
    }
    public function changeMail()
    {
        if (isset($_POST['subMail'])) {
            $newMail = $_POST['changeMail'];
            $mail2 = $_SESSION['login'];
            if (($newMail != '')) {
                    $sql = "UPDATE users SET mail ='$newMail' WHERE mail = '$mail2'";
                    $stmt = $this->bdd->prepare($sql);
                    $stmt->execute();
                    $_SESSION['login'] = $newMail;
                    echo 'Votre adresse-mail a bien été modifiée !';
            }
        }
    }
}
