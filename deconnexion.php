<?php
session_start();
unset($_SESSION["login"]);
unset($_SESSION["nom"]);
unset($_SESSION["prenom"]);
unset($_SESSION["age"]);
unset($_SESSION["mail"]);
session_destroy();
header('Location: connexion.php');
exit();
?>