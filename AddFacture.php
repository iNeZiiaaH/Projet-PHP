<?php
require_once 'functions/utils.php';
require_once 'functions/SessionError.php';
require_once 'Classes/MessageSuccess/AddFactureSuccess.php';
require_once 'Classes/MessageError/AddFactureError.php';

// fonction qui redirige vers la page de connexion si l'utilisateur essaye de passer par URL sans être connecter
SessionError();

// récupération de la BDD
require_once 'bdd-link/bdd-link.php';

// Vérification si le formulaire a été soumis.
if (isset($_POST['submit'])) {

    // Validation du formulaire 
    $client_id = $_POST['client_id'];
    $date_facture = $_POST['date_facture'];
    $commentaire = $_POST['commentaire'];
    $total = $_POST['prix_total'];
    $ligne_facture = $_POST['lignes_facture'];


    // Insertion des données dans la table "facture"
    $query = "INSERT INTO Facture (numero_facture, date_facture, total, commentaire, client_id) VALUES (:numero_facture, :date_facture, :total, :commentaire, :client_id)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'numero_facture' => uniqid(), // génération d'un numéro de facture unique
        'date_facture' => $date_facture,
        'commentaire' => $commentaire,
        'client_id' => $client_id,
        'total' => $total
    ]);

    // Récupération de l'id de la dernière facture insérée avec la fonction lastInsertId 
    $id_facture = $pdo->lastInsertId();

    $total = 0;
    foreach ($ligne_facture as $lignes) {
        $description = $lignes['description'];
        $quantite = isset($lignes['quantite']) ? $lignes['quantite'] : 0;
        $prix_unitaire = isset($lignes['prix_unitaire']) ? $lignes['prix_unitaire'] : 0;
        $prix_total = intVal($quantite) * intVal($prix_unitaire);

        $total += $prix_total;

        // Insertion des données dans la table "ligne_facture"
        $query = "INSERT INTO Ligne_Facture (description, quantite, prix_unitaire, prix_total, id_facture) VALUES (:description, :quantite, :prix_unitaire, :prix_total, :id_facture)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'description' => $description,
            'quantite' => $quantite,
            'prix_unitaire' => $prix_unitaire,
            'prix_total' => $prix_total,
            'id_facture' => $id_facture
        ]);
    }

    if ($id_facture == 0) {
        redirect('Facture.php?error=' . FactureError::FACTURE_ERROR);
    } else {
        redirect('Facture.php?success=' . FactureSuccess::ADD_FACTURE_SUCCESS);
    }
}
