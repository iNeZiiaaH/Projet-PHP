<?php
require_once 'Classes/MessageError/LoginError.php';
require_once 'functions/utils.php';
require_once 'functions/SessionError.php';

// fonction qui redirige vers la page de connexion si l'utilisateur essaye de passer par URL sans être connecter
SessionError();

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
    ]); ?>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center m-4"> Détails du Client</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Chiffre d'affaire sur l'année</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $stmt->fetch()) { ?>
                            <tr>
                                <td><?php echo $row['nom']; ?></td>
                                <td><?php echo $row['total_sum']; ?> €</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php } 

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
