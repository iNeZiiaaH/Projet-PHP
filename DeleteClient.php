<?php

require_once 'bdd-link/bdd-link.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {

    $id_client = $_GET['id'];

    $query = "DELETE FROM client WHERE id =:id";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':id', $id_client, PDO::PARAM_INT);
    $stmt->execute();

    header('location: Client.php');
}
