<h2 class="text-center m-5">Ajouer une facture</h2>
<form method="post" action="AddFacture.php">
	<div class="d-flex justify-content-center gap-5">
		<label for="client_id">Client :</label>
		<select name="client_id" id="client" required>
			<?php while ($row = $stmt->fetch()) { ?>
				<option value="<?php echo $row['id']; ?>"><?php echo $row['nom']; ?></option>
			<?php } ?>
		</select>
		<br>
		<label for="commentaire">commentaire :</label>
		<textarea name="commentaire"></textarea>

		<label for="date_facture">Date de facture :</label>
		<input type="date" id="date_facture" name="date_facture" required>
	</div>
	<br>

	<h2 class="text-center"> Ligne de facture</h2>

	<div id="lignes_facture" class="row row-cols-6 justify-content-center">
		<div class="lignes_factures">
			<label for="description_1"> Description :</label>
			<input type="text" id="" name="lignes_facture[0][description]" required>

			<label for="quantite_1"> Quantite :</label>
			<input type="number" id="quantite" name="lignes_facture[0][quantite]" min="1" required onchange="updatePrixTotal()">

			<label for="prix_unitaire_1"> Prix Unitaire :</label>
			<input type="number" id="prix_unitaire" name="lignes_facture[0][prix_unitaire]" min="0" required onchange="updatePrixTotal()">

		</div>
	</div>
	<label for="prix_total">Prix total :</label>
	<input type="number" id="prix_total" name="prix_total" required readonly>

	<div class="d-flex justify-content-center mt-5">
		<button type="button" onclick="ajoutLigneFacture()"> Ajouter une ligne de facture</button>
		<input type="submit" name="submit" value="Créer la facture">
	</div>

</form>

<div class="d-flex justify-content-center">
	<a href="SearchFacture.php" class="btn btn-dark text-center mt-5">Rechercher une facture</a>
</div>


if (isset($_POST['submit'])) {

// Validation du formulaire 
$client_id = $_POST['client_id'];
$date_facture = $_POST['date_facture'];
$commentaire = $_POST['commentaire'];
$total = $_POST['prix_total'];
$ligne_facture = $_POST['lignes_facture'];


// Insertion des données dans la table "facture"
$query = "INSERT INTO Facture (numero_facture, date_facture, total, commentaire, client_id) VALUES (:numero_facture, :date_facture, :total, :commentaire, :client_id)";
$stmt = $pdo->prepare($query);
$stmt->execute([
	'numero_facture' => uniqid(), // génération d'un numéro de facture unique
	'date_facture' => $date_facture,
	'commentaire' => $commentaire,
	'client_id' => $client_id,
	'total' => $total
]);

// Récupération de l'id de la dernière facture insérée avec la fonction lastInsertId 
$id_facture = $pdo->lastInsertId();

$total = 0;
foreach ($ligne_facture as $lignes) {
	$description = $lignes['description'];
	$quantite = isset($lignes['quantite']) ? $lignes['quantite'] : 0;
	$prix_unitaire = isset($lignes['prix_unitaire']) ? $lignes['prix_unitaire'] : 0;
	$prix_total = intVal($quantite) * intVal($prix_unitaire);

	$total += $prix_total;

	// Insertion des données dans la table "ligne_facture"
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

if ($id_facture == 0) {
	redirect('Facture.php?error=' . FactureError::FACTURE_ERROR);
} else {
	redirect('Facture.php?success=' . FactureSuccess::ADD_FACTURE_SUCCESS);
}
}