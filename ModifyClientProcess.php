<?php
require_once 'functions/utils.php';
require_once 'functions/SessionError.php';
require_once 'Classes/MessageSuccess/ModifyClientSuccess.php';
require_once 'Classes/ViewClient.php';

// fonction qui redirige vers la page de connexion si l'utilisateur essaye de passer par URL sans être connecter
SessionError();

require_once 'bdd-link/bdd-link.php';


if (isset($_POST['modifier_client'])) {

    // Condition pour que les champs sois tous remplis sinon il ne peut pas envoyer la requête
    if (empty($_POST['email']) || empty($_POST['nom']) || empty($_POST['domaine']) || empty($_POST['adresse']) || empty($_POST['ville']) || empty($_POST['code_postal']) || empty($_POST['pays'])) {
        echo 'Veuillez remplire tous les champs';
        exit;
    }

    $client = new Client($pdo);
    $result = $client->ModifyClient($_GET['id'], $_POST['email'], $_POST['nom'], $_POST['domaine'], $_POST['adresse'], $_POST['ville'], $_POST['code_postal'], $_POST['pays']);

    if ($result) {
        redirect('ModifyClient.php?success=' . ModifyClientSuccess::MODIFY_CLIENT_SUCCESS . "&id=" . $id_client);
    } else {
        echo "Erreur de la modification du client";
    }
}
