<?php
include('connexionbdd.class.php');

class Inscription
{

    protected $dateDeNaissance;
    protected $pseudo;
    protected $nom;
    protected $prenom;
    protected $mail;
    protected $pays;
    protected $motDePass;
    protected $connexion;
    protected $bdd;

    public function __construct($newDN, $newMail, $newMDP, $newPseudo, $newPrenom, $newNom, $newPays = "france")
    {
        $this->pseudo = $newPseudo;
        $this->dateDeNaissance = $newDN;
        $this->mail = $newMail;
        $this->motDePass = $newMDP;
        $this->nom = $newNom;
        $this->prenom = $newPrenom;
        $this->pays = $newPays;
        $this->connexion = new Connexion();
        $this->bdd = $this->connexion->getDB();
    }

    public function insert()
    {
        $query = $this->bdd->prepare('INSERT INTO users (mail,pseudo,password) VALUES (?,?,?)');
        $query->execute(
            array(
                $this->mail,
                $this->pseudo,
                hash_hmac('ripemd160', $this->motDePass, 'vive le projet tweet_academy')
            )
        );

        $queryosef = $this->bdd->query('SELECT id FROM `users` order by id desc limit 1 ');
        $result = $queryosef->fetch();

        $query2 = $this->bdd->prepare('insert into user_info (id_user, birthdate,pays,name,surname) VALUES (?,?,?,?,?)');
        $query2->execute(
            array(
                $result['id'],
                $this->dateDeNaissance,
                $this->pays,
                $this->nom,
                $this->prenom
            )
        );
        $addFollow = $this->bdd->prepare('insert into follow (id_user,follows) values (?, " ")');
        $addFollow->execute(array($result['id']));
    }

    public function checkEmail($email)
    {
        $check = $this->bdd->prepare('select mail from users where mail=?');
        $check->execute(array($email));

        if ($check->rowCount() >= 1) {
            return false;
        } else {
            return true;
        }
    }
    public function checkPseudo($pseudo)
    {
        $queryPseudo = $this->bdd->prepare('select pseudo from users where pseudo=?');
        $queryPseudo->execute(array($pseudo));
        if($queryPseudo->rowCount() >= 1){
            return false;
        }else{
            return true;
        }
    }

    public function error($msg)
    {
        echo '<div class="alert alert-danger alert-dismissible fade show">
        <strong>Error!</strong>' . $msg . '</div>';
    }

    public function valide($confirm)
    {
        echo '<div class="alert alert-success" role="alert">
        <strong>Félicitation</strong> ' . $confirm . '.
      </div>';
    }
}
