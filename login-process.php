<?php
require_once 'functions/utils.php';
require_once 'Classes/LoginError.php';
require_once 'Classes/LoginSuccess.php';
require_once './bdd-link/bdd-link.php';

$login = $_POST['login'];
$password = $_POST['pass'];


// requête SQL pour récuperer la colonne 
$query = "SELECT * FROM Utilisateur WHERE login = :login";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':login', $login, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

session_start();
if ($user == $user and $password == $user['pass']) {
    $_SESSION['connected'] = true;
    redirect('Accueil.php?success=' . LoginSuccess::LOGIN_SUCCESS);
    exit;
} else {
    redirect('login.php?error=' . LoginError::LOGIN_INVALID);
}
// // hasher le mot de passe actuel de l'administrateur
// $hashed_password = password_hash($password['pass'], PASSWORD_DEFAULT);

// // mettre à jour le champ du mot de passe dans la base de données
// $query = "UPDATE Utilisateur SET pass = :pass WHERE login = :login";
// $stmt = $pdo->prepare($query);
// $stmt->bindValue(':pass', $hashed_password, PDO::PARAM_STR);
// $stmt->bindValue(':login', $login, PDO::PARAM_STR); 
// $stmt->execute();

// session_start();
// if ($user && password_verify($password, $user['pass'])) {
//     $_SESSION['connected'] = true;
//     redirect('Accueil.php?success=' . LoginSuccess::LOGIN_SUCCESS);
//     exit;
// } else {
//     redirect('login.php?error=' . LoginError::LOGIN_INVALID);
// }
