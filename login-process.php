<?php
session_start();
require_once 'functions/utils.php';
require_once 'Classes/MessageError/LoginError.php';
require_once 'Classes/MessageSuccess/LoginSuccess.php';
require_once 'Classes/login.php';
require_once __DIR__ . '/bdd-link/bdd-link.php';

if (empty($_POST) || !isset($_POST['login']) || !isset($_POST['pass'])) {
    redirect('login.php?error=' . LoginError::FILLING_THE_FIELDS);
}

$login = $_POST['login'];
$password = $_POST['pass'];

// J'instancie ma classe Login qui a comme paramètre le login, password et pdo.
$Authentication = new login($login, $password, $pdo);
// Puis je récupère ma méthode pour s'authentifier
$Authentication->authenticate();
