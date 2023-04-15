<?php
require_once 'functions/utils.php';
require_once 'Classes/MessageSuccess/AddFactureSuccess.php';
require_once 'Classes/MessageError/AddFactureError.php';
require_once 'Classes/Facture.php';

// récupération de la BDD
require_once __DIR__ . '/bdd-link/bdd-link.php';

// Vérification si le formulaire a été soumis.
if (isset($_POST['submit'])) {

    // J'instancie un objet de la classe Facture
    $facture = new Facture($_POST['date_facture'], $_POST['commentaire'], $_POST['prix_total'], $_POST['lignes_facture'], $_POST['client_id']);

    // J'appelle la méthode InsertFacture pour insérer les données dans la base de données
    $facture->InsertFacture();
}
