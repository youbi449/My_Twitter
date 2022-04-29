<?php
session_start();
include('classes/handler.php');

$ayoub = new Messagerie();

$afficher = $ayoub->getUser();

?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link href="styles/main.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="./styles/home.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">

  <title>Messages</title>
  <link rel="stylesheet" type="text/css" href="./styles/message.css">
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

        <!-- LE CHAMP DE RECHERCHE -->

        <div class="s003">
          <form action="search.php" method="get">
            <div class="inner-form">
              <div class="input-field first-wrap">
                <div class="input-select">
                  <select data-trigger="" name="type" class="select">
                    <option placeholder="">Plus</option>
                    <option value="Tweet">Tweet & Hashtag</option>
                    <option value="User">Utilisateurs</option>
                  </select>
                </div>
              </div>
              <div class="input-field second-wrap">
                <input type="text" name="search" placeholder="Rechercher..." />
              </div>
              <div class="input-field third-wrap">
                <button class="btn-search" type="submit">
                  <svg class="svg-inline--fa fa-search fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path>
                  </svg>
                </button>
              </div>
            </div>
          </form>
        </div>
        <script src="scripts/extention/choices.js"></script>
        <script>
          const choices = new Choices('[data-trigger]', {
            searchEnabled: false,
            itemSelectText: '',
          });
        </script>
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

  <!-- ZONE DE CHAT -->

  <div class="mdr">
        <?php 
          echo $afficher;
          ?>
  </div>

</body>

</html>