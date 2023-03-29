<?php
require_once 'Classes/LoginError.php';
require_once 'functions/utils.php';
require_once 'Layout/header.php';
require_once 'Layout/navbar.php';


// condition qui dis que si utilisateur n'est pas connecté alors il est renvoyé vers la page login.php
session_start();
if ($_SESSION == false) {
    redirect('login.php?error=' . LoginError::CONNECTION_FAILED);
}

// requête pour récuperer le total de chaque facture 

// SELECT c.nom_client, SUM(lf.prix_total) AS chiffre_affaire
// FROM client 
// JOIN facture  ON c.client_id = f.client_id
// JOIN ligne_facture lf ON f.numero_facture = lf.id_facture
// GROUP BY c.client_id;