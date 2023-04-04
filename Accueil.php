<?php
// Récupération des fonctions
require_once 'functions/utils.php';
require_once 'functions/SessionError.php';

// Récupération des classes pour les erreurs et les succès
require_once 'Classes/MessageError/LoginError.php';
require_once 'Classes/MessageSuccess/LoginSuccess.php';

// fonction qui redirige vers la page de connexion si l'utilisateur essaye de passer par URL sans être connecter
SessionError();

require_once 'bdd-link/bdd-link.php';

require_once 'Layout/header.php';
require_once 'Layout/navbar.php'; ?>

<?php
// Récupération des dernières factures
$stmt = $pdo->prepare("SELECT f.numero_facture, f.date_facture, f.total, c.nom 
        FROM facture f 
        JOIN client c ON f.client_id = c.id 
        ORDER BY f.date_facture DESC 
        LIMIT 10");
$stmt->execute();
$factures = $stmt->fetchAll();

// Récupération du chiffre d'affaires total
$stmt = $pdo->prepare("SELECT SUM(total) AS chiffre_affaires FROM facture");
$stmt->execute();
$chiffre_affaires = $stmt->fetchColumn();

// Récupération des clients les plus actifs
$stmt = $pdo->prepare("SELECT c.nom, COUNT(*) AS nombre_factures, SUM(f.total) AS montant_total 
        FROM facture f 
        JOIN client c ON f.client_id = c.id 
        GROUP BY c.nom 
        ORDER BY montant_total DESC 
        LIMIT 10");
$stmt->execute();
$clients = $stmt->fetchAll();

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center mb-4">Tableau de bord</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h2 class="mb-3">Dernières factures</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Numéro de facture</th>
                        <th>Date de facture</th>
                        <th>Total</th>
                        <th>Client</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($factures as $facture) { ?>
                        <tr>
                            <td><?php echo $facture["numero_facture"]; ?></td>
                            <td><?php echo $facture["date_facture"]; ?></td>
                            <td><?php echo $facture["total"]; ?>€</td>
                            <td><?php echo $facture["nom"]; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <h2 class="mb-3">Clients les plus actifs</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Nombre de factures</th>
                        <th>Montant total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clients as $client) { ?>
                        <tr>
                            <td><?php echo $client["nom"]; ?></td>
                            <td><?php echo $client["nombre_factures"]; ?></td>
                            <td><?php echo $client["montant_total"]; ?>€</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <p class="text-center">Chiffre d'affaires total : <?php echo $chiffre_affaires; ?>€</p>
        </div>
    </div>
</div>

<?php
if (array_key_exists('success', $_GET)) { ?>
    <div class="alert alert-success text-center">
        <?php echo LoginSuccess::getSuccessMessage(intval($_GET['success'])); ?>
    </div>
<?php }

require_once 'Layout/footer.php';
