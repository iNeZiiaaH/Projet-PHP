<?php
// je récupère ma classe ViewClient
require_once 'Classes/ClientCrud.php';

// on crée une instance de la classe ViewClient
$client = new Client($pdo);

if (isset($_GET['id'])) {
    echo $client->afficherClient($_GET['id']);
}
