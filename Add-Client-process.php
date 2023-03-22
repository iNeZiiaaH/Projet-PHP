<?php
require_once 'Classes/LoginError.php';

// condition qui dis que si utilisateur n'est pas connecté alors il est renvoyé vers la page login.php
session_start();
if (!$_SESSION['connected']) {
    header('location: login.php?error=' . LoginError::CONNECTION_FAILED);
}

if (empty($_POST['email']) || empty($_POST['nom']) || empty($_POST['domaine']) || empty($_POST['adresse']) || empty($_POST['ville']) || empty($_POST['code_postal']) || empty($_POST['pays'])) {
    echo 'Veuillez remplire tous les champs';
    exit;
}
$email = $_POST['email'];
$nom = $_POST['nom'];
$domaine = $_POST['domaine'];
$adresse = $_POST['adresse'];
$ville = $_POST['ville'];
$code_postal = $_POST['code_postal'];
$pays = $_POST['pays'];

// On récupère la BDD
require_once 'bdd-link/bdd-link.php';


$stmt = $pdo->prepare('SELECT COUNT(*) FROM client WHERE email = ? && nom = ? && domaine = ? && adresse = ? && ville = ? && code_postal = ? && pays = ?');
$stmt->bindValue(1, $email, PDO::PARAM_STR);
$stmt->bindValue(2, $nom, PDO::PARAM_STR);
$stmt->bindValue(3, $domaine, PDO::PARAM_STR);
$stmt->bindValue(4, $adresse, PDO::PARAM_STR);
$stmt->bindValue(5, $ville, PDO::PARAM_STR);
$stmt->bindValue(6, $code_postal, PDO::PARAM_STR);
$stmt->bindValue(7, $pays, PDO::PARAM_STR);
$stmt->execute();
$count = $stmt->fetchColumn();

//condition si un utilisateur existe deja , grace a la requête sql au dessus
if ($count > 0) {
    echo 'Un Client existe déjà.' . "<br />";
} else {
    
    // Ajouter le cleint à la base de données
    $stmt = $pdo->prepare('INSERT INTO client (email, nom, domaine, adresse, ville, code_postal, pays) VALUES (? , ? , ? , ? , ? , ? , ?)'); // requête SQL Pour insérer un nouveau user
    $stmt->bindValue(1, $email, PDO::PARAM_STR);
    $stmt->bindValue(2, $nom, PDO::PARAM_STR);
    $stmt->bindValue(3, $domaine, PDO::PARAM_STR);
    $stmt->bindValue(4, $adresse, PDO::PARAM_STR);
    $stmt->bindValue(5, $ville, PDO::PARAM_STR);
    $stmt->bindValue(6, $code_postal, PDO::PARAM_STR);
    $stmt->bindValue(7, $pays, PDO::PARAM_STR);
    $stmt->execute();
    
    // Afficher un message de confirmation
    echo 'Client ajouté avec succès.';
}