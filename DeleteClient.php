<?php
require_once 'functions/utils.php';
require_once 'Classes/LoginError.php';

// condition qui dis que si utilisateur n'est pas connecté alors il est renvoyé vers la page login.php
session_start();
if (!$_SESSION['connected']) {
    redirect('login.php?error=' . LoginError::CONNECTION_FAILED);
}

require_once 'bdd-link/bdd-link.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {

    $id_client = $_GET['id'];

    $query = "DELETE FROM client WHERE id =:id";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':id', $id_client, PDO::PARAM_INT);
    $stmt->execute();

    header('location: Client.php');
    // ajouter classe pour afficher un message success
}
