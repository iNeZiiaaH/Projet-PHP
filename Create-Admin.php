<?php
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
