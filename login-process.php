<?php
session_start();
require_once 'functions/utils.php';
require_once 'Classes/MessageError/LoginError.php';
require_once 'Classes/MessageSuccess/LoginSuccess.php';
require_once __DIR__ . '/bdd-link/bdd-link.php';

if (empty($_POST) || !isset($_POST['login']) || !isset($_POST['pass'])) {
    redirect('login.php');
}

$login = $_POST['login'];
$password = $_POST['pass'];

$query = "SELECT pass FROM Utilisateur WHERE login = :login";
$stmt = $pdo->prepare($query);
$stmt->execute(['login' => $login]);

$user = $stmt->fetch();

if ($user === false) {
    redirect('login.php?error=' . LoginError::LOGIN_INVALID);
}

$hashedPassword = $user['pass'];
if (password_verify($password, $hashedPassword) === false) {
    redirect('login.php?error=' . LoginError::PASSWORD_INVALID);
}

$_SESSION['Connected'] = true;
redirect('Accueil.php?success=' . LoginSuccess::LOGIN_SUCCESS);
