<?php
// Récupération des fonctions
require_once 'functions/utils.php';
require_once 'functions/SessionError.php';

// Récupération des classes pour les erreurs et les succès
require_once 'Classes/MessageError/LoginError.php';
require_once 'Classes/MessageError/AddClientError.php';
require_once 'Classes/MessageError/IncompleteFields.php';
require_once 'Classes/MessageSuccess/AddClientSuccess.php';

// Récupération de la classe ClientCrud pour pouvoir utiliser la méthode 
require_once 'Classes/ClientCrud.php';

// fonction qui redirige vers la page de connexion si l'utilisateur essaye de passer par URL sans être connecter
SessionError();

// Condition pour que les champs sois tous remplis sinon il ne peut pas envoyer la requête
if (empty($_POST['email']) || empty($_POST['nom']) || empty($_POST['domaine']) || empty($_POST['adresse']) || empty($_POST['ville']) || empty($_POST['code_postal']) || empty($_POST['pays'])) {
    // redirection vers la page pour ajouter les clients avec un message d'erreurs.
    redirect('Add-Client.php?error=' . IncompleteFields::INCOMPLETE_FIELDS);
    exit;
}
// On récupère la BDD
require_once 'bdd-link/bdd-link.php';

// j'instancie la classe ClientCrud
$AjouterClient = new ClientCrud($pdo);

// Puis j'utilise la méthode pour ajouter le client 
$AjouterClient->AddClient();
