<?php
require_once 'functions/utils.php';

// récupération de la BDD
require_once 'bdd-link/bdd-link.php';

// Vérification si le formulaire a été soumis.
if (isset($_POST) && !empty($_POST)) {
    
    // Validation du formulaire 
    $client_id = $_POST["client_id"];
    $date_facture = $_POST["date_facture"];
    $total = $_POST["total"];
    $commentaire = $_POST["commentaire"];
    $description = $_POST["description"];
    $quantite = $_POST["quantite"];
    $prix_unitaire = $_POST["prix_unitaire"];
    $prix_total = $_POST["prix_total"];


    // Insertion des données dans la table "facture"
    $query = "INSERT INTO Facture (numero_facture, date_facture, total, commentaire, client_id) VALUES (:numero_facture, :date_facture, :total, :commentaire, :client_id)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'numero_facture' => uniqid(), // génération d'un numéro de facture unique
        'date_facture' => $date_facture,
        'total' => $total,
        'commentaire' => $commentaire,
        'client_id' => $client_id
    ]);

    // Récupération de l'id de la dernière facture insérée avec la fonction lastInsertId 
    $id_facture = $pdo->lastInsertId();

    // Insertion des données dans la table "ligne_facture"
    foreach ($description as $prix_total) {
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

    redirect("location: Facture.php");
}
