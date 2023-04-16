<?php
require_once 'Classes/Statistique.php';
require_once 'Classes/MessageError/LoginError.php';
require_once 'functions/SessionError.php';
require_once 'functions/utils.php';

require_once __DIR__ . '/bdd-link/bdd-link.php';

SessionError();


// on instancie la classe Statistique
$statistique = new Statistique($pdo);

if (isset($_GET['id'])) {

    $client_id = $_GET['id'];
    // Je récupére la méthode pour récupèrer les statistiques de chaque client
    $clientDetails = $statistique->getClientDetails($client_id);
?>
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
                        <?php foreach ($clientDetails as $row) { ?>
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

