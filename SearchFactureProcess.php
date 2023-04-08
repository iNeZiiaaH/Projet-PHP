<?php
require_once 'functions/SessionError.php';
require_once 'functions/utils.php';
require_once 'Classes/MessageError/LoginError.php';

// fonction qui redirige vers la page de connexion si l'utilisateur essaye de passer par URL sans être connecter
SessionError();
// je verifie si id du client est défénie dans URL. Si il est définie je le stock dans une variable, puis j'effectue ma requête pour récupérer toutes les factures de chaque client.

if (isset($_GET['id'])) {
    $clientid = $_GET['id'];

    $query_client = "SELECT nom FROM client WHERE id = :client_id";
    $stmt_client = $pdo->prepare($query_client);
    $stmt_client->execute([
        'client_id' => $clientid
    ]);
    $client_nom = $stmt_client->fetchColumn();

    $query_Facture = "SELECT * FROM Facture WHERE client_id = :client_id";
    $stmt_Facture = $pdo->prepare($query_Facture);
    $stmt_Facture->execute([
        'client_id' => $clientid
    ]);

?>
    <div class="container mt-3 text-center">
        <h2>Liste des factures</h2>
        <hr>
        <h3 class="mb-3">Facture pour le client : <?php echo $client_nom; ?></h3>

        <!-- j'effectue une première boucle pour parcourir chaque facture et récupérer les informations. -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php while ($stmt_Factures = $stmt_Facture->fetch()) { ?>
                <div class="col">
                    <div class="card border-dark">
                        <div class="card-header">
                            <h5 class="card-title m-0">Facture n° <?php echo $stmt_Factures['numero_facture']; ?></h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text"> Date : <?php echo $stmt_Factures['date_facture'] ?></p>
                            <p class="card-text"> Total : <?php echo $stmt_Factures['total'] ?>€</p>
                            <p class="card-text"> Commentaire : <?php echo $stmt_Factures['commentaire'] ?></p>

                            <!-- j'effectue ma deuxième requête pour récupérer les informations des lignes de la factures en effectuant une boucle. -->
                            <?php
                            $query_Ligne_Facture = "SELECT * FROM Ligne_Facture WHERE id_facture = :id";
                            $stmt_Ligne_Facture = $pdo->prepare($query_Ligne_Facture);
                            $stmt_Ligne_Facture->execute([
                                'id' => $stmt_Factures["id"]
                            ]);
                            ?>

                            <ul class="list-group list-group-flush">
                                <?php while ($Ligne_Facture = $stmt_Ligne_Facture->fetch()) { ?>
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between">
                                            <div class="me-auto">
                                                <p class="card-text">Produit : <?php echo $Ligne_Facture['description'] ?></p>
                                                <p class="card-text">Quantité : <?php echo $Ligne_Facture['quantite'] ?></p>
                                            </div>
                                            <div class="text-end">
                                                <p class="card-text">Prix unitaire : <?php echo $Ligne_Facture['prix_unitaire'] ?>€</p>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>

                            <!-- Bonus essayer éditer la facture son forme de PDF avec FPDF -->
                            <div class="mt-3 text-end">
                                <a href="FacturePDF.php?id=<?php echo $stmt_Factures['id']; ?>" class="btn btn-sm btn-dark">Télécharger</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php }
