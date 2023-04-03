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
<?php } ?>

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

<?php
//Afficher le message que le facture à bien été supprimé
if (array_key_exists('error', $_GET)) { ?>
	<div class="alert alert-danger text-center">
		<?php echo FactureError::getErrorMessage(intval($_GET['error'])); ?>
	</div>
<?php }
?>

<script defer>
	function updatePrixTotal() {
		var quantites = document.querySelectorAll("#quantite");
		var prix_unitaires = document.querySelectorAll("#prix_unitaire");
		var prix_total = 0;
		for (i = 0; i < quantites.length; i++) {
			prix_total += quantites[i].value * prix_unitaires[i].value;
		}
		document.getElementById("prix_total").value = prix_total;
	}


	function ajoutLigneFacture() {
		var lignesFacture = document.getElementById("lignes_facture");
		var nouvelleLigneFacture = document.createElement("div");
		nouvelleLigneFacture.classList.add("lignes_facture");

		var index = lignesFacture.childElementCount; // on obtient le nombre de ligne actuelle 
		var labels = ["Description", "Quantité", "Prix unitaire"];
		var id = ["description", "quantite", "prix_unitaire"];
		// var obj = [{id: "description", label : "Description"},{id: "quantite", label : "Quantité"},{id: "prix_unitaire", label : "Prix unitaire}]

		for (var i = 0; i < labels.length; i++) {
			var label = document.createElement("label");
			label.textContent = labels[i] + " :";

			var input = document.createElement("input");
			input.type = i === 0 ? "text" : "number";
			// je configure l'attribut name, toLowerCase() = id est convertie en minuscule , il évite les problème de casse
			input.name = "lignes_facture[" + index + "][" + id[i].toLowerCase().replace("  ", "_") + "]";
			input.min = i === 1 ? 1 : 0;
			input.required = true;
			input.id = id[i];
			input.onchange = updatePrixTotal;

			nouvelleLigneFacture.appendChild(label);
			nouvelleLigneFacture.appendChild(input);
		}

		lignesFacture.appendChild(nouvelleLigneFacture);
	}
</script>

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