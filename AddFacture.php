<?php
require_once 'functions/utils.php';

// // Condition pour que les champs sois tous remplis sinon il ne peut pas envoyer la requête
// if (empty($_POST['email']) || empty($_POST['nom']) || empty($_POST['domaine']) || empty($_POST['adresse']) || empty($_POST['ville']) || empty($_POST['code_postal']) || empty($_POST['pays'])) {
//     echo 'Veuillez remplire tous les champs';
//     exit;
// }

require_once 'bdd-link/bdd-link.php';


// if (isset($_POST['submit'])) {
//     // Récupération des données du formulaire de création de facture
//     $numero_facture = isset($_POST['numero_facture']) ? $_POST['numero_facture'] : '';
//     $date_facture =isset($_POST['date_facture']) ? $_POST['date_facture'] : '';
//     $id_client = isset($_POST['client_id']) ? $_POST['client_id'] : '';
//     $commentaire = $_POST['commentaire'];

//     // Insertion de la nouvelle facture dans la base de données
//     $stmt = $pdo->prepare('INSERT INTO facture (numero_facture, date_facture, client_id, commentaire) VALUES (?, ?, ?, ?)');
//     if(!empty($numero_facture)){
//         $stmt->execute([$numero_facture, $date_facture, $client_id, $nom_produit]);
//     }else{
//         // Gérer le cas où $numero_facture est vide ou non défini
//     }

//     // Récupération de l'identifiant de la facture créée
//     $id_facture = $pdo->lastInsertId();

//     // Vérification de la soumission du formulaire de création de lignes de facture
//     if (isset($_POST['lignes_facture'])) {
//         // Récupération des données du formulaire de création de lignes de facture
//         $lignes_facture = $_POST['lignes_facture'];

//         foreach ($lignes_facture as $ligne_facture) {
//             $description = $ligne_facture['description'];
//             $quantite = $ligne_facture['quantite'];
//             $prix_unitaire = $ligne_facture['prix_unitaire'];

//             // Calcul du prix total HT et TTC de la ligne de facture
//             $prix_total = $quantite * $prix_unitaire;

//             // Insertion de la nouvelle ligne de facture dans la base de données
//             $stmt = $pdo->prepare('INSERT INTO ligne_facture (id_facture, description, quantite, prix_unitaire, prix_total) VALUES (?, ?, ?, ?, ?)');
//             $stmt->execute([$id_facture, $description, $quantite, $prix_unitaire, $prix_total]);
//         }
//     }
// }
