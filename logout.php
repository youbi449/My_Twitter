<?php
session_start();
session_destroy();
session_unset();
header('location:index.php');

/* enleve toute les sessions et redirige vers l'index */