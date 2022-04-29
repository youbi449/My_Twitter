<?php
session_start();

if (!isset($_GET['pseudo'])) {
    header('location:home.php');
}
include('classes/profilMembre.class.php');


$currentUser = new Membre($_GET['pseudo']);

if ($currentUser->checkUserExist()) {

    $tweet = $currentUser->getTweet();
    $tweetResult = "";

    foreach ($tweet as $value) {
        $tweetResult .=     '<div class="main-container">
        <div class="container_bis">
            <div class="tweet-card">
                <img class="avatar" src="https://pbs.twimg.com/profile_images/983370939122495489/hPTuWnVP_400x400.jpg">

                <div class="content">
                    <div class="author">
                        <a href="profil.php" class="twitter-name" target="_blank"> ' . $value['pseudo'] . '</a>
                        <span class="twitter-handle"><a href="#"></a>@' . $value['pseudo'] . '</span>
                        <a href="#" class="twitter-time">Il y a --min</a>
                    </div>

                    <p class="tweet">' . $value['post_content'] . '</p>

                    <ul class="actions">
                        <li>
                            <button>
                                <span class="fas fa-reply"></span>
                            </button>
                        </li>
                        <li>
                            <button>
                                <span class="fas fa-retweet"></span>
                            </button>
                        </li>
                        <li>
                            <button>
                                <span class="fas fa-heart"></span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>';
    }
} else {
    header('location:error404.php');
}

try {
    $bdd = new PDO('mysql:dbname=common_database;host=localhost', 'root', '');
} catch (Exception $e) {
    die('Connexion échoué :' . $e->getMessage());
}

/* La je vais chercher l'id de l'utilisateur que tu veut follow pour ma fonction */
$getProfilID = $bdd->prepare('select id from users where pseudo=?');
$getProfilID->execute(array($_GET['pseudo']));
$profilId = $getProfilID->fetch();

// Obtention du nombre de followers


if ($currentUser->getNbrTweet($profilId['id']) == false)
    $fetchTweet = 0;
else {
    $fetchTweet = $currentUser->getNbrTweet($profilId['id']);
}

$InfoCurrentUser = $currentUser->getInfoMembre($profilId['id']);
?>





<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>twitter
    </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="./styles/style_profil.css">
</head>

<body>

    <!-- LA NAV BAR -->

    <nav class="navbar navbar-expand navbar-light bg-white">
        <div class="container">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a href="home.php" class="nav-link">
                            <svg viewBox="0 0 24 24">
                                <g>
                                    <path d="M22.46 7.57L12.357 2.115c-.223-.12-.49-.12-.713 0L1.543 7.57c-.364.197-.5.652-.303 1.017.135.25.394.393.66.393.12 0 .243-.03.356-.09l.815-.44L4.7 19.963c.214 1.215 1.308 2.062 2.658 2.062h9.282c1.352 0 2.445-.848 2.663-2.087l1.626-11.49.818.442c.364.193.82.06 1.017-.304.196-.363.06-.818-.304-1.016zm-4.638 12.133c-.107.606-.703.822-1.18.822H7.36c-.48 0-1.075-.216-1.178-.798L4.48 7.69 12 3.628l7.522 4.06-1.7 12.015z"></path>
                                    <path d="M8.22 12.184c0 2.084 1.695 3.78 3.78 3.78s3.78-1.696 3.78-3.78-1.695-3.78-3.78-3.78-3.78 1.696-3.78 3.78zm6.06 0c0 1.258-1.022 2.28-2.28 2.28s-2.28-1.022-2.28-2.28 1.022-2.28 2.28-2.28 2.28 1.022 2.28 2.28z"></path>
                                </g>
                            </svg>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="message.php" class="nav-link">
                            <svg viewBox="0 0 24 24">
                                <g>
                                    <path d="M19.25 3.018H4.75C3.233 3.018 2 4.252 2 5.77v12.495c0 1.518 1.233 2.753 2.75 2.753h14.5c1.517 0 2.75-1.235 2.75-2.753V5.77c0-1.518-1.233-2.752-2.75-2.752zm-14.5 1.5h14.5c.69 0 1.25.56 1.25 1.25v.714l-8.05 5.367c-.273.18-.626.182-.9-.002L3.5 6.482v-.714c0-.69.56-1.25 1.25-1.25zm14.5 14.998H4.75c-.69 0-1.25-.56-1.25-1.25V8.24l7.24 4.83c.383.256.822.384 1.26.384.44 0 .877-.128 1.26-.383l7.24-4.83v10.022c0 .69-.56 1.25-1.25 1.25z">
                                    </path>
                                </g>
                            </svg>
                        </a>
                    </li>
                </ul>
                <form action="search_acceuil.php" class="form-inline w-100 d-none d-md-block ml-2">
                    <input type="text" class="form-control form-control-sm rounded-pill search border-0 px-3 w-100" placeholder="Rechercher...">
                </form>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="26" height="26" viewBox="0 0 26 26" style=" fill:#000000;">
                            <g id="surface1">
                                <path style=" " d="M 13 0 C 5.832031 0 0 5.832031 0 13 C 0 20.167969 5.832031 26 13 26 C 20.167969 26 26 20.167969 26 13 C 26 5.832031 20.167969 0 13 0 Z M 13 2 C 19.085938 2 24 6.914063 24 13 C 24 15.859375 22.90625 18.453125 21.125 20.40625 C 20.375 19.027344 18.167969 17.894531 15.8125 17.40625 C 15.8125 17.40625 14.6875 17.101563 15.1875 16 C 15.886719 15.101563 16.3125 14.113281 16.3125 13.8125 C 16.3125 13.8125 17.304688 13.011719 17.40625 11.8125 C 17.507813 10.710938 17.1875 10.59375 17.1875 10.59375 C 17.585938 9.292969 17.695313 4.398438 14.59375 5 C 14.09375 4 10.8125 3.207031 9.3125 5.90625 C 8.613281 7.207031 8.300781 9.101563 9 10.5 C 9 10.601563 8.789063 10.394531 8.6875 11.09375 C 8.6875 11.792969 9.011719 12.789063 9.3125 13.1875 C 9.414063 13.386719 9.613281 13.492188 9.8125 13.59375 C 9.8125 13.59375 10.007813 14.804688 10.90625 15.90625 C 11.105469 16.804688 10.1875 17.3125 10.1875 17.3125 C 7.75 17.800781 5.535156 18.933594 4.78125 20.3125 C 3.050781 18.371094 2 15.8125 2 13 C 2 6.914063 6.914063 2 13 2 Z "></path>
                            </g>
                        </svg>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="profil.php">Profil</a>
                        <a class="dropdown-item" href="option.php">Paramètre</a>
                        <a class="dropdown-item" href="logout.php">Déconnexion</a>
                    </div>
                </li>
            </div>
        </div>
    </nav>


    <!-- PROFIL -->

    <section class="profile">
        <header class="header">
            <div class="details">
                <img src="https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-0.3.5&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjE0NTg5fQ&s=b38c22a46932485790a3f52c61fcbe5a" alt="John Doe" class="profile-pic">
                <h1 class="heading"></h1>
                <div class="location">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12,11.5A2.5,2.5 0 0,1 9.5,9A2.5,2.5 0 0,1 12,6.5A2.5,2.5 0 0,1 14.5,9A2.5,2.5 0 0,1 12,11.5M12,2A7,7 0 0,0 5,9C5,14.25 12,22 12,22C12,22 19,14.25 19,9A7,7 0 0,0 12 ,2Z"></path>
                    </svg>
                    <?php echo "<p>" . $InfoCurrentUser['pays'] . "</p>"; ?>
                </div>
                <div class="stats">
                    <div class="col-4">
                        <h4><?php $currentUser->getFollowing($profilId['id']); ?></h4>
                        <p>Followings</p>
                    </div>
                    <div class="col-4">
                        <h4><?php $currentUser->getFollower($profilId['id']) ?></h4>
                        <p>Followers</p>
                    </div>
                    <div class="col-4">
                        <h4><?php echo $fetchTweet['count(post_content)']; ?></h4>
                        <p>Tweets</p>
                    </div>
                </div>
            </div>
            <?php
/*             if ($currentUser->checkIfFollowOrNot($profilId['id'])) {

                echo '<input type="button" id="follow" value="Follow">';
            } else {

                echo '<input type="button" id="follow" value="Unfollow">';
            } */
            $currentUser->checkIfFollowOrNot($profilId['id']);
            ?>
        </header>
    </section>
    <?php echo $tweetResult; ?>
    <script src="jquery/jquery-3.4.1.min.js"></script>
    <script src="scripts/script.js"></script>
    <script>
        /* Requete AJAX pour follow */
        $('#follow').click(function() {
            $.ajax({

                type: 'POST',

                url: 'follow.php',

                data: {
                    pseudo: '<?php echo $_GET['pseudo']; ?>'
                },

                timeout: 3000,

                error: function(xhr, textStatus, errorThrown) {

                    alert(xhr.responseText);

                }

            });

        });
    </script>
</body>

</html>