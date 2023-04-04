<?php
session_start();
require_once 'functions/utils.php';
require_once 'Classes/MessageError/LoginError.php';
require_once 'Classes/MessageSuccess/LoginSuccess.php';
require_once 'Classes/login.php';

require_once __DIR__ . '/bdd-link/bdd-link.php';

if (empty($_POST) || !isset($_POST['login']) || !isset($_POST['pass'])) {
    redirect('login.php');
}

$login = $_POST['login'];
$password = $_POST['pass'];

$Authentication = new login($login, $password, $pdo);
$Authentication->authenticate();
