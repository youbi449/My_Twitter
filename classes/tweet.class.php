<?php

require_once 'connexionbdd.class.php';

class tweet
{

    protected $connexion;
    protected $bdd;
    private $id_user;

    public function __construct($id)
    {
        $this->id_user = $id;
        $this->connexion = new Connexion();
        $this->bdd = $this->connexion->getDB();
    }

    public function checkIfLikeOrNot($id_tweet)
    {

        $checkLike = $this->bdd->prepare('select * from post where id_post=?');
        $checkLike->execute(array($id_tweet));
        $like = "";

        while ($checking = $checkLike->fetch()) {
            $like .= $checking['post_like'];
        }

        $parsing = explode(',', $like);
        foreach ($parsing as $value) {
            $listLike = $this->bdd->prepare('select post_like from post where id_post=?');
            $listLike->execute(array($id_tweet));
            $nbr = $listLike->fetchAll();
            $listeDesLike = count(explode(",", $nbr['0']['0']));
            if ($_SESSION['id'] == $value) {

                return '<form method="get" action="like.php">
                <input type="hidden" name="tweet" value="' . $id_tweet . '">
                <button type="submit" class="fas fa-heart" style="color:red"></button>
                <a href="listeLike.php?id_tweet=' . $id_tweet . '">' . ($listeDesLike - 1) . '</a>
            </form>';
            } else {
                return '<form method="get" action="like.php">
                <input type="hidden" name="tweet" value="' . $id_tweet . '">
                <button type="submit" class="fas fa-heart" ></button>
                <a href="listeLike.php?id_tweet=' . $id_tweet . '">' . ($listeDesLike - 1) . '</a>
                </form>';
            }
        }
    }

    public function addLike($who, $tweet)
    {
        $checkLike = $this->bdd->prepare('select count(*) as "a" from post where id_post=? AND post_like like "%' . $who . '%"');
        $checkLike->execute(array(
            $tweet
        ));
        $check = $checkLike->fetch();

        if ($check['a'] < 1) {
            $unfollow = $this->bdd->prepare('update post set post_like = concat(post_like,?) where id_post=?');
            $unfollow->execute(array($who . ',', $tweet));
        } else {
            $follow = $this->bdd->prepare('update post set post_like = replace(post_like,"' . $who . ',","") where id_post=?');
            $follow->execute(array($tweet));
        }
    }

    public function getInfo($mail)
    {
        $info = $this->bdd->prepare('select * from users INNER join user_info where users.id = user_info.id_user && mail =?');
        $info->execute(array($mail));
        return $info->fetch();
    }


    public function addTweet($tweet, $pic = false)
    {

        $info = $this->getInfo($_SESSION['login']);
        $tableauMotTweet = explode(" ", $tweet);
        $newTweet = [];
        $listHashtag = "";
        foreach ($tableauMotTweet as $value) {
            if ($value[0] == "#") {
                $listHashtag .= $value . ',';
                $value = "<a href='search.php?search=" . substr($value, 1) . "&type=Tweet'>" . $value . "</a>";
            }
            if ($value[0] == "@") {
                $value = "<a href='membre.php?pseudo=" . substr($value, 1) . "'>" . $value . "</a>";
            }
            array_push($newTweet, $value);
        }
        $newTweet = implode(" ", $newTweet);

        if ($listHashtag == "") {
            if ($pic == false) {
                echo "pas de photo";
                $insert = $this->bdd->prepare('insert into post (id_user,post_content,post_date) VALUES (?,?,?)');
                $insert->execute(array(
                    $info['id'],
                    $newTweet,
                    date("Y-m-d H:i:s")
                ));
            } else {
                $insert = $this->bdd->prepare('insert into post (id_user,post_content,post_date,hasMedia,media_id) VALUES (?,?,?,?,?)');
                $insert->execute(array(
                    $info['id'],
                    $newTweet,
                    date("Y-m-d H:i:s"),
                    "1",
                    $pic
                ));
            }
        } else {
            if ($pic == false) {
                $insert = $this->bdd->prepare('insert into post (id_user,post_content,post_date,hashtags) VALUES (?,?,?,?)');
                $insert->execute(array(
                    $info['id'],
                    $newTweet,
                    date("Y-m-d H:i:s"),
                    $listHashtag
                ));
            } else {
                $insert = $this->bdd->prepare('insert into post (id_user,post_content,post_date,hashtags,hasMedia,media_id) VALUES (?,?,?,?,?,?)');
                $insert->execute(array(
                    $info['id'],
                    $newTweet,
                    date("Y-m-d H:i:s"),
                    $listHashtag,
                    "1",
                    $pic
                ));
            }
        }
    }

    public function storeImg($tweet, $file)
    {
        $typeAutorisees = array('png', 'jpg', 'jpeg', 'gif');
        $imageStocker = "image/";
        $nomImage = basename($file);
        $typeimg = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $newName = uniqid("Uploaded-", true);
        $cibleImage = $imageStocker . $newName . '.' . $typeimg;



        if (in_array($typeimg, $typeAutorisees)) {
            if (move_uploaded_file($_FILES['photo']["tmp_name"], $cibleImage)) {
                $insert = $this->bdd->prepare('insert into media (media) VALUES (?)');
                $insert->execute(array(
                    $newName . '.' . $typeimg
                ));
                if ($insert) {
                    $this->statut = "Your file: " . $nomImage . "   has been uploaded successfully";
                } else {
                    $this->statut = "File upload failed. Please try again.";
                }
            } else {
                $this->statut = "It seems there is a problem with the upload of your file";
            }
        } else {
            $this->statut = "Sorry, only png, jpg, jpeg and gif is authorized";
        }
        $id = $this->bdd->prepare('select id_media from media where media = ?');
        $id->execute(array($newName . '.' . $typeimg));
        $resultat = $id->fetch();
        $this->addTweet($tweet, $resultat['id_media']);
    }

    public function getUserWhoLike($id_tweet)
    {
        $query = $this->bdd->prepare('select post_like from post where id_post=?');
        $query->execute(array($id_tweet));
        $idfetch = $query->fetchAll();
        $idListeDesLike = explode(',', $idfetch['0']['0']);
        $echo = "";

        foreach ($idListeDesLike as $value) {
            $getUserDetails = $this->bdd->prepare('select * from users where id=?');
            $getUserDetails->execute(array($value));
            while ($userDetails = $getUserDetails->fetch()) {
                $echo .= "<a href='membre.php?pseudo=" . $userDetails['pseudo'] . "'>" . $userDetails['pseudo'] . "</a><br>";
            }
        }
        echo $echo;
    }
}
