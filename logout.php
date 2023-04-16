<?php
require_once 'functions/utils.php';
require_once 'functions/SessionError.php';
require_once 'Classes/MessageError/LoginError.php';
require_once 'Classes/MessageSuccess/LogoutSuccess.php';

SessionError();
$_SESSION = [];
session_destroy(); // pour détruire la session 
redirect('login.php?success=' . LogoutSuccess::LOGOUT_SUCCESS); // redirige vers la page de connexion avec le message que utilisateur c'est bien déconnecté 