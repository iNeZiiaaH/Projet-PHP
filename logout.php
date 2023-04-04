<?php
require_once 'functions/utils.php';
require_once 'Classes/MessageSuccess/LogoutSuccess.php';

session_start(); // Bien penser à utiliser session_start, sinon $_SESSION indéfini !
$_SESSION = [];
session_destroy(); // pour détruire la session 
redirect('login.php?success=' . LogoutSuccess::LOGOUT_SUCCESS); // redirige vers la page de connexion