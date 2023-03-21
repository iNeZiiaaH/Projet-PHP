<?php
require_once './bdd-link/bdd-link.php';

$login = $_POST['login'];
$password = $_POST['pass'];

// requête SQL pour récuperer la colonne 
$query = "SELECT * FROM Utilisateur WHERE login = :login";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':login', $login);
$stmt->execute(); 
$user = $stmt->fetch(PDO::FETCH_ASSOC); 

session_start();
if ($user == $user AND $password == $user['pass']) {
    $_SESSION['connected'] = true;
    header("location: Accueil.php?success=1");
    exit;
} else {
    header("location: login.php?error=1");
}
