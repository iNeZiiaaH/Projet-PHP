<?php
// je verifie si id du client est défénie dans URL. Si il est définie je le stock dans une variable, puis j'effectue ma requête pour récupérer toutes les factures de chaque client.

if (isset($_GET['id'])) {
    $clientid = $_GET['id'];

    $query_client = "SELECT nom FROM client WHERE id = :client_id";
    $stmt_client = $pdo->prepare($query_client);
    $stmt_client->execute([
        'client_id' => $clientid
    ]);
    $client_nom = $stmt_client->fetchColumn();

    $query = "SELECT * FROM Facture WHERE client_id = :client_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'client_id' => $clientid
    ]);

?>
    <div class="container mt-3 text-center">
        <h2>Liste des factures</h2>
        <hr>
        <h3 class="mb-3">Facture pour le client : <?php echo $client_nom; ?></h3>

        <!-- j'effectue une première boucle pour parcourir chaque facture et récupérer les informations. -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php while ($stmt1 = $stmt->fetch()) { ?>
                <div class="col">
                    <div class="card border-dark">
                        <div class="card-header">
                            <h5 class="card-title m-0">Facture n° <?php echo $stmt1['numero_facture']; ?></h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text"> Date : <?php echo $stmt1['date_facture'] ?></p>
                            <p class="card-text"> Total : <?php echo $stmt1['total'] ?>€</p>
                            <p class="card-text"> Commentaire : <?php echo $stmt1['commentaire'] ?></p>

                            <!-- j'effectue ma deuxième requête pour récupérer les informations des lignes de la factures en effectuant une boucle. -->
                            <?php
                            $query2 = "SELECT * FROM Ligne_Facture WHERE id_facture = :id";
                            $stmt2 = $pdo->prepare($query2);
                            $stmt2->execute([
                                'id' => $stmt1["id"]
                            ]);
                            ?>

                            <ul class="list-group list-group-flush">
                                <?php while ($row = $stmt2->fetch()) { ?>
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between">
                                            <div class="me-auto">
                                                <p class="card-text">Produit : <?php echo $row['description'] ?></p>
                                                <p class="card-text">Quantité : <?php echo $row['quantite'] ?></p>
                                            </div>
                                            <div class="text-end">
                                                <p class="card-text">Prix unitaire : <?php echo $row['prix_unitaire'] ?>€</p>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>

                            <!-- Bonus essayer éditer la facture son forme de PDF avec FPDF -->
                            <div class="mt-3 text-end">
                                <a href="FacturePDF.php?id=<?php echo $stmt1['id']; ?>" class="btn btn-sm btn-dark">Télécharger</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php }
