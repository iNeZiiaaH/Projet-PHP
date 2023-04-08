<?php
require_once 'functions/utils.php';
require_once 'functions/SessionError.php';
require_once 'Classes/MessageError/LoginError.php';
require_once 'Classes/MessageSuccess/AddFactureSuccess.php';
require_once 'Classes/MessageError/AddFactureError.php';

require_once 'Layout/header.php';
require_once 'Layout/navbar.php';

// fonction qui redirige vers la page de connexion si l'utilisateur essaye de passer par URL sans être connecter
SessionError();

// Récupération Base de donnée 
require_once 'bdd-link/bdd-link.php';

//  requête pour récuperer tous les clients de la BDD
$query = "SELECT * FROM client";
$stmt = $pdo->prepare($query);
$stmt->execute();
?>

<?php
// Afficher le message que la facture a été crée
if (array_key_exists('success', $_GET)) { ?>
	<div class="alert alert-success text-center">
		<?php echo FactureSuccess::getSuccessMessage(intval($_GET['success'])); ?>
	</div>
<?php } 

//Afficher le message que le facture à bien été supprimé
if (array_key_exists('error', $_GET)) { ?>
	<div class="alert alert-danger text-center">
		<?php echo FactureError::getErrorMessage(intval($_GET['error'])); ?>
	</div>
<?php }
?>

<div class="container mt-5">
	<h2 class="text-center">Ajouter une facture</h2>
	<a href="SearchFacture.php" class="btn btn-dark">Rechercher une facture</a>
	<form method="post" action="AddFacture.php">
		<div class="row mt-5">
			<div class="col-4">
				<label for="client_id" class="form-label">Client :</label>
				<select name="client_id" id="client" class="form-select" required>
					<?php while ($row = $stmt->fetch()) { ?>
						<option value="<?php echo $row['id']; ?>"><?php echo $row['nom']; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-4">
				<label for="commentaire" class="form-label">Commentaire :</label>
				<textarea name="commentaire" id="commentaire" class="form-control"></textarea>
			</div>
			<div class="col-4">
				<label for="date_facture" class="form-label">Date de facture :</label>
				<input type="date" id="date_facture" name="date_facture" class="form-control" required>
			</div>
		</div>

		<div class="row mt-5">
			<div class="col">
				<h2 class="text-center"> Ligne de facture</h2>
				<div id="lignes_facture" class="row justify-content-center">
					<div class="col-4">
						<label for="description_1" class="form-label">Description :</label>
						<input type="text" id="" name="lignes_facture[0][description]" class="form-control" required>
					</div>
					<div class="col-4">
						<label for="quantite_1" class="form-label">Quantité :</label>
						<input type="number" id="quantite" name="lignes_facture[0][quantite]" class="form-control" min="1" required onchange="updatePrixTotal()">
					</div>
					<div class="col-4">
						<label for="prix_unitaire_1" class="form-label">Prix Unitaire :</label>
						<input type="number" id="prix_unitaire" name="lignes_facture[0][prix_unitaire]" class="form-control" required onchange="updatePrixTotal()" step="0.01">
					</div>
				</div>
				<label for="prix_total" class="form-label">Prix total :</label>
				<input type="number" id="prix_total" name="prix_total" class="form-control" required readonly>
			</div>
		</div>

		<div class="row mt-5">
			<div class="col text-center">
				<button type="button" class="btn btn-primary" onclick="ajoutLigneFacture()">Ajouter une ligne de facture</button>
				<input type="submit" name="submit" class="btn btn-success" value="Créer la facture">
			</div>
		</div>
	</form>
</div>

<!-- Je viens récupérer mes scripts JS pour calculer automatiquement le prix total + le fichier pour ajouter des lignes dans la factures -->
<script defer src="Assets/template/UpdatePrixTotal.js"></script>
<script defer src="Assets/template/AddInvoiceLine.js"></script>


<!-- Test v2 -->
<script>
	// function updatePrixTotal() {
	// 	var quantites = document.querySelectorAll("#quantite");
	// 	var prix_unitaires = document.querySelectorAll("#prix_unitaire");
	// 	var prix_total = 0;
	// 	for (i = 0; i < quantites.length; i++) {
	// 		prix_total += quantites[i].value * prix_unitaires[i].value;
	// 	}
	// 	document.getElementById("prix_total").value = prix_total;
	// }


	// function ajoutLigneFacture() {
	// 	var lignesFacture = document.getElementById("lignes_facture");
	// 	var nouvelleLigneFacture = document.createElement("div");
	// 	nouvelleLigneFacture.classList.add("lignes_facture");

	// 	var index = lignesFacture.childElementCount; // on obtient le nombre de ligne actuelle 
	// 	var labels = ["Description", "Quantité", "Prix unitaire"];
	// 	var id = ["description", "quantite", "prix_unitaire"];
	// 	// var obj = [{id: "description", label : "Description"},{id: "quantite", label : "Quantité"},{id: "prix_unitaire", label : "Prix unitaire}]

	// 	for (var i = 0; i < labels.length; i++) {
	// 		var label = document.createElement("label");
	// 		label.textContent = labels[i] + " :";

	// 		var input = document.createElement("input");
	// 		input.type = i === 0 ? "text" : "number";
	// 		// je configure l'attribut name, toLowerCase() = id est convertie en minuscule , il évite les problème de casse
	// 		input.name = "lignes_facture[" + index + "][" + id[i].toLowerCase().replace("  ", "_") + "]";
	// 		input.min = i === 1 ? 1 : 0;
	// 		input.required = true;
	// 		input.id = id[i];
	// 		input.onchange = updatePrixTotal;

	// 		nouvelleLigneFacture.appendChild(label);
	// 		nouvelleLigneFacture.appendChild(input);
	// 	}

	// 	lignesFacture.appendChild(nouvelleLigneFacture);
	// }
</script>

<!-- test v1 -->
<?php
// // on récupère le bouton pour ajouter les lignes
// const btnAjouterChamp = document.querySelector("#ajouter_ligne");

// // on récupère la div
// const champsContainer = document.querySelector("#champs-container");

// btnAjouterChamp.addEventListener("click", function() {
// // on vient crée les nouveau champs
// const champDesignation = document.createElement("input");
// champDesignation.label = "designation";
// champDesignation.type = "texte";
// champDesignation.name = "designation[]";

// const champQuantite = document.createElement("input");
// champQuantite.label = "quantite";
// champQuantite.type = "number";
// champQuantite.name = "quantite[]";

// const champPrixUnitaire = document.createElement("input");
// champPrixUnitaire.label = "prix_unitaire";
// champPrixUnitaire.type = "number";
// champPrixUnitaire.name = "prix_unitaire[]";

// // on ajoute les nouveaux champs au container
// champsContainer.appendChild(champDesignation);
// champsContainer.appendChild(champQuantite);
// champsContainer.appendChild(champPrixUnitaire);
// });