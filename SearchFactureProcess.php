<?php

// Je verifie si id du client est définie dans URL. Si il est définie je le stock dans une variable, puis j'effectue ma requête pour récupérer toute les factures de ce client.
if (isset($_GET['id'])) {
    $clientid = $_GET['id'];

    $query = "SELECT * FROM Facture WHERE client_id = :client_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'client_id' => $clientid
    ]);
?>
    <!-- j'effectue une boucle pour parcourir chaque facture est récupérer les information -->
    <div class="row row-cols-4 justify-content-center gap-5">
        <?php while ($stmt1 = $stmt->fetch()) { ?>
            <div class="d-flex card  mt-5" style="width: 18rem;">
                <div class="card-body text-center">
                    <h5 class="card-title"> Facture n° <?php echo $stmt1['numero_facture']; ?></h5>
                    <p class="card-text"> Date : <?php echo $stmt1['date_facture'] ?></p>
                    <p class="card-text"> Total : <?php echo $stmt1['total'] ?>€</p>
                    <p class="card-text"> Commentaire : <?php echo $stmt1['commentaire'] ?></p>

                    <!-- j'effectue une deuxième requête pour récupérer cette fois-ci les lignes de la facture -->
                    <?php
                    $query2 = "SELECT * FROM Ligne_Facture WHERE id_facture = :id";
                    $stmt2 = $pdo->prepare($query2);
                    $stmt2->execute([
                        'id' => $stmt1["id"]
                    ]);

                    // j'effectue une autre boucle qui parcours la table ligne facture est récupérer les informations
                    while ($row = $stmt2->fetch()) { ?>
                        <p class="card-text">Produit : <?php echo $row['description'] ?></p>
                        <p class="card-text">Quantité : <?php echo $row['quantite'] ?></p>
                        <p class="card-text">Prix unitaire : <?php echo $row['prix_unitaire'] ?>€</p>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>

<?php } ?>