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

// Récupération Base de donnée 
require_once 'bdd-link/bdd-link.php';

//  requête pour récuperer tous les clients de la BDD
$query = "SELECT * FROM client";
$stmt = $pdo->prepare($query);
$stmt->execute();

// Récupération du header et de la NavBar
require_once 'Layout/header.php';
require_once 'Layout/navbar.php'; ?>

<h1 class="text-center">Choisir le client dans la liste</h1>

<div class="d-flex justify-content-center mt-5 ">
    <form action="" method="get" class="d-flex gap-3 w-50">
        <select name="id" class="form-select" aria-label="Default select example">
            <option selected>Sélectionner un Client</option>
            <?php while ($row = $stmt->fetch()) { ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['nom']; ?></option>
            <?php } ?>
        </select>
        <button type="submit" class="btn btn-dark">Rechercher</button>
    </form>
</div>

<?php

if (isset($_GET['id'])) {

    // V2

    $client_id = $_GET['id'];

    $query = 'SELECT client.nom, SUM(total) AS total_sum FROM Facture
                JOIN client ON Facture.client_id = client.id
                WHERE Facture.client_id = :client_id
                GROUP BY client.id';
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'client_id' => $client_id
    ]);

    while ($row = $stmt->fetch()) {
        $client_nom =$row['nom'];
        $total_sum = $row['total_sum'];

        echo "Client : $client_nom, Chiffre d'affaire sur l'année : $total_sum €";
    }

    //V1 pour afficher les totals de chaque client

    // $client_id = $_GET['id'];

    // $query = "SELECT client_id, SUM(total) as total_sum FROM Facture WHERE client_id = :client_id";
    // $stmt = $pdo->prepare($query);
    // $stmt->execute([
    //     'client_id' => $client_id
    // ]
    // );

    // $result = $stmt->fetch();
    // $total_sum = $result['total_sum'];

    //     // afficher les résultats
    //     echo "Chiffre d'affaire du client : " . $clientNom. " : ". $total_sum. "€";
    }



?>