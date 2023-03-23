<?php

session_start(); // Bien penser à utiliser session_start, sinon $_SESSION indéfini !
$_SESSION = [];
session_destroy(); // pour détruire la session 
header('location: login.php'); // redirige vers la page de connexion