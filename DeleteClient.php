<?php
require_once 'functions/utils.php';
require_once 'functions/SessionError.php';
require_once 'Classes/MessageError/LoginError.php';
require_once 'Classes/MessageSuccess/DeleteClientSuccess.php';

// fonction qui redirige vers la page de connexion si l'utilisateur essaye de passer par URL sans être connecter
SessionError();

require_once 'bdd-link/bdd-link.php';

if (isset($_GET['id'])) {

    $id_client = $_GET['id'];

    $query = "DELETE FROM client WHERE id =:id";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':id', $id_client, PDO::PARAM_INT);
    $stmt->execute();

    redirect('Client.php?success=' . DeleteClientSuccess::DELETE_CLIENT_SUCCESS);
}
