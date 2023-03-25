<?php
require_once 'functions/utils.php';
require_once 'Classes/LoginError.php';
require_once 'Classes/AddClientError.php';
require_once 'Classes/AddClientSuccess.php';

// condition qui dis que si utilisateur n'est pas connecté alors il est renvoyé vers la page login.php
session_start();
if (!$_SESSION['connected']) {
    redirect('login.php?error=' . LoginError::CONNECTION_FAILED);
}

// Condition pour que les champs sois tous remplis sinon il ne peut pas envoyer la requête
if (empty($_POST['email']) || empty($_POST['nom']) || empty($_POST['domaine']) || empty($_POST['adresse']) || empty($_POST['ville']) || empty($_POST['code_postal']) || empty($_POST['pays'])) {
    echo 'Veuillez remplire tous les champs';
    exit;
}

try {
    // On récupère la BDD
    require_once 'bdd-link/bdd-link.php';

    // On récupère les champs voulu
    $email = $_POST['email'];
    $nom = $_POST['nom'];
    $domaine = $_POST['domaine'];
    $adresse = $_POST['adresse'];
    $ville = $_POST['ville'];
    $code_postal = $_POST['code_postal'];
    $pays = $_POST['pays'];

    // On vérifie si l'email existe déjà dans la base de données
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM client WHERE email = ?');
    $stmt->bindValue(1, $email, PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    //condition si un utilisateur existe deja , grace a la requête sql au dessus
    if ($count > 0) {
        redirect('Add-Client.php?error=' . ClientErro::EMAIL_EXISTS ); 
    } else {

        // Ajouter le cleint à la base de données
        $stmt = $pdo->prepare('INSERT INTO client (email, nom, domaine, adresse, ville, code_postal, pays) VALUES (? , ? , ? , ? , ? , ? , ?)'); // requête SQL Pour insérer un nouveau user
        $stmt->bindValue(1, $email, PDO::PARAM_STR);
        $stmt->bindValue(2, $nom, PDO::PARAM_STR);
        $stmt->bindValue(3, $domaine, PDO::PARAM_STR);
        $stmt->bindValue(4, $adresse, PDO::PARAM_STR);
        $stmt->bindValue(5, $ville, PDO::PARAM_STR);
        $stmt->bindValue(6, $code_postal, PDO::PARAM_INT);
        $stmt->bindValue(7, $pays, PDO::PARAM_STR);
        $stmt->execute();

        // Afficher un message de confirmation
        redirect('Add-Client.php?success=' . ClientSuccess::ADD_CLIENT_SUCCESS);
    }
} catch (Exception $e) {
    echo "Une erreur est survenue lors de la création du client : " . $e->getMessage();
    redirect('Add-Client.php?error=');
}
