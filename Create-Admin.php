<?php
require_once 'functions/utils.php';
require_once 'Classes/LoginError.php';

// condition qui dis que si utilisateur n'est pas connecté alors il est renvoyé vers la page login.php
session_start();
if ($_SESSION == false) {
    redirect('login.php?error=' . LoginError::CONNECTION_FAILED);
}
require_once 'bdd-link/bdd-link.php';

$login = "admin";
$password = "admin";

$query = "INSERT INTO Utilisateur VALUES (null, :login, :pass)";
$stmt = $pdo->prepare($query);

$insert = $stmt->execute([
    'login' => $login,
    'pass' => password_hash($password, PASSWORD_DEFAULT)
]);

if ($insert) {
    echo "Utilisateur enregistré";
} else {
    echo "Échec lors de l'insertion";
}
