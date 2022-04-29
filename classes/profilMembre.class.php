<?php

include('connexionbdd.class.php');

class Membre
{
    protected $user;
    protected $id;
    protected $connexion;
    protected $bdd;

    public function __construct($newUser)
    {
        $this->user = $newUser;
        $this->connexion = new Connexion();
        $this->bdd = $this->connexion->getDB();
        $this->setId();
    }

    public function setId()
    {

        $getId = $this->bdd->prepare('select id from users where pseudo=?');
        $getId->execute(array($this->user));
        $userid = $getId->fetch();
        $this->id = $userid['id'];
    }

    public function checkUserExist()
    {
        $check = $this->bdd->prepare('select pseudo from users where pseudo =?');
        $check->execute(array($this->user));
        if ($check->rowCount() >= 1) {
            return true;
        } else {
            return false;
        }
    }



    public function getTweet()
    {
        $queryTweet = $this->bdd->prepare('select pseudo,post_content from post where id_user =?');
        $queryTweet->execute(array($this->id));
        return $queryTweet->fetchAll();
    }

    public function getFollower($id)
    {
        $queryfollower = $this->bdd->query('select count(follows) from follow where follows like "%' . $id . ',%"');
        $resultat = $queryfollower->fetch();
        echo $resultat['count(follows)'];
    }

    public function getFollowing($id)
    {
        $queryFollowing = $this->bdd->prepare('select follows from follow where id_user=?');
        $queryFollowing->execute(array($id));
        $resultat = $queryFollowing->fetch();
        $calcul = explode(",", $resultat['follows']);
        echo count($calcul) - 1;
    }

    public function getNbrTweet($id)
    {
        $queryNbrTweet = $this->bdd->prepare('select count(post_content) from post where id_user=?');
        $queryNbrTweet->execute(array($id));
        return $queryNbrTweet->fetch();
    }

    public function follow(string $id)
    {
        $checkFollowingOrNot = $this->bdd->prepare('select count(*) as "a" from follow where id_user =? and follows like "%' . $id . '%"');
        $checkFollowingOrNot->execute(array(
            $this->id
        ));
        $check = $checkFollowingOrNot->fetch();

        if ($check['a'] < 1) {
            $unfollow = $this->bdd->prepare('update follow set follows = concat(follows,?) where id_user=?');
            $unfollow->execute(array($id . ',', $this->id));
        } else {
            $follow = $this->bdd->prepare('update follow set follows = replace(follows,"' . $id . ',","") where id_user =?');
            $follow->execute(array($this->id));
        }
    }

    public function checkIfFollowOrNot($id)
    {
        $checkFollowingOrNot = $this->bdd->query('select count(*) as "lol" from follow where id_user =' . $this->id . ' and follows like "%' . $id . ',%"');
        $resultCheck = $checkFollowingOrNot->fetch();
        if ($resultCheck['lol'] == 1) {
            echo '<input type="button" id="follow" value="Unfollow">';
        } else {
            echo '<input type="button" id="follow" value="Follow">';
        }
    }

    public function getThisTweet()
    {
        $getTweet = $this->bdd->prepare('select post_content from post where id_user=?');
        $getTweet->execute(array($this->id));
        return $getTweet->fetchAll();
    }



    public function getInfoMembre($id)
    {
        $info = $this->bdd->prepare('select * from users INNER join user_info where users.id = user_info.id_user && id =?');
        $info->execute(array($id));
        return $info->fetch();
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
    public function basicQuery($newQuery)
    {
        return $this->bdd->query($newQuery);
    }
}
