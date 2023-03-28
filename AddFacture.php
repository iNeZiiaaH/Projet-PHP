<?php
require_once 'functions/utils.php';
require_once 'Classes/AddFactureSuccess.php';
require_once 'Classes/AddFactureError.php';

// récupération de la BDD
require_once 'bdd-link/bdd-link.php';

// Vérification si le formulaire a été soumis.
if (!empty($_POST)) {

    // Validation du formulaire 
    $client_id = $_POST['client_id'];
    $date_facture = $_POST['date_facture'];
    $commentaire = $_POST['commentaire'];
    $designation = $_POST['designation'];
    $quantite = $_POST['quantite'];
    $prix_unitaire = $_POST['prix_unitaire'];
    $prix_total = $_POST['prix_total'];


    // Insertion des données dans la table "facture"
    $query = "INSERT INTO Facture (numero_facture, date_facture, commentaire, client_id) VALUES (:numero_facture, :date_facture, :commentaire, :client_id)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'numero_facture' => uniqid(), // génération d'un numéro de facture unique
        'date_facture' => $date_facture,
        'commentaire' => $commentaire,
        'client_id' => $client_id
    ]);

    // Récupération de l'id de la dernière facture insérée avec la fonction lastInsertId 
    $id_facture = $pdo->lastInsertId();

    // Insertion des données dans la table "ligne_facture"
    $query = "INSERT INTO Ligne_Facture (designation, quantite, prix_unitaire, prix_total, id_facture) VALUES (:designation, :quantite, :prix_unitaire, :prix_total, :id_facture)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'designation' => $designation,
        'quantite' => $quantite,
        'prix_unitaire' => $prix_unitaire,
        'prix_total' => $prix_total,
        'id_facture' => $id_facture
    ]);

    if ($id_facture == 0) {
        redirect('Facture.php?error=' . FactureError::FACTURE_ERROR);
    } else {
        redirect('Facture.php?success=' . FactureSuccess::ADD_FACTURE_SUCCESS);
    }
}
