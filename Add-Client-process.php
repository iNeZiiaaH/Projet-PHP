<?php
require_once 'functions/utils.php';
require_once 'functions/SessionError.php';
require_once 'Classes/MessageError/LoginError.php';
require_once 'Classes/MessageError/AddClientError.php';
require_once 'Classes/MessageSuccess/AddClientSuccess.php';
require_once 'Classes/ClientCrud.php';

// fonction qui redirige vers la page de connexion si l'utilisateur essaye de passer par URL sans être connecter
SessionError();

// Condition pour que les champs sois tous remplis sinon il ne peut pas envoyer la requête
if (empty($_POST['email']) || empty($_POST['nom']) || empty($_POST['domaine']) || empty($_POST['adresse']) || empty($_POST['ville']) || empty($_POST['code_postal']) || empty($_POST['pays'])) {
    echo 'Veuillez remplire tous les champs';
    exit;
}


    // On récupère la BDD
    require_once 'bdd-link/bdd-link.php';

    $AjouterClient = new ClientCrud($pdo);
    $AjouterClient->AjouterClient();

