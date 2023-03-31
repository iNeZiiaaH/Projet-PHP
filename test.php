<?php

require_once 'Layout/header.php';
require_once 'Layout/navbar.php';

require_once 'functions/utils.php';
require_once 'Classes/LoginError.php';
require_once 'Classes/AddFactureSuccess.php';
require_once 'Classes/AddFactureError.php';


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
?>
?>

<h1 class="texte-center">Ajouter une facture</h1>
<form method="post" action="AddFacture.php">
	<label for="client_id">Client :</label>
	<select name="client_id" id="client" required>
		<?php while ($row = $stmt->fetch()) { ?>
			<option value="<?php echo $row['id']; ?>"><?php echo $row['nom']; ?></option>
		<?php } ?>
	</select>
	<br>
	<label for="commentaire">commentaire :</label>
	<textarea name="commentaire"></textarea>
	<br>

	<h2> Ligne de facture</h2>

	<div id="lignes_facture">
		<div class="lignes_factures">
			<label for="description_1"> Description :</label>
			<input type="text" name="lignes_facture[0][description]" required>

			<label for="quantite_1"> Quantite :</label>
			<input type="number" name="lignes_facture[0][quantite]" min="1" required>

			<label for="prix_unitaire_1"> Prix Unitaire :</label>
			<input type="number" name="lignes_facture[0][prix_unitaire]" min="0" step="0.01" required>
		</div>
	</div>

	<button type="button" onclick="ajoutLigneFacture()"> Ajouter une ligne de facture</button>
	<input type="submit" name="submit" value="Créer la facture">
</form>

<!-- J'ajoute du JS pour pouvoir rajouter des lignes pour les factures -->
<script>
	function ajoutLigneFacture() {
		var lignesFacture = document.getElementById("lignes_facture");
		var nouvelleLigneFacture = document.createElement("div");
		nouvelleLigneFacture.classList.add("ligne_facture");

		var index = lignesFacture.childElementCount;
		var labels = ["Description", "Quantité", "Prix unitaire"];

		for (var i = 0; i < labels.length; i++) {
			var label = document.createElement("label");
			label.textContent = labels[i] + " :";

			var input = document.createElement("input");
			input.type = i === 0 ? "text" : "number";
			input.name = "lignes_facture[" + index + "][" + labels[i].toLowerCase().replace("  ", "_") + "]";
			input.min = i === 1 ? 1 : 0;
			input.step = "0.01";
			input.required = true;
			label.style.margin = "10px 0";
			input.style.margin = "10px 0";


			nouvelleLigneFacture.appendChild(label);
			nouvelleLigneFacture.appendChild(input);
		}

		lignesFacture.appendChild(nouvelleLigneFacture);
	}
</script>


form method="POST" action="AddFacture.php">

	<label for="date_facture">Date de facture :</label>
	<input type="date" id="date_facture" name="date_facture" required>

	<label for="commentaire">Commentaire :</label>
	<textarea id="commentaire" name="commentaire"></textarea>

	<label for="client_id">Client :</label>
	<select id="client_id" name="client_id">
		<?php while ($row = $stmt->fetch()) { ?>
			<option value="<?php echo $row['id']; ?>"><?php echo $row['nom']; ?></option>
		<?php } ?>
	</select>
	<br>

	<div id="champs-container">
		<label for="designation">Designation : </label>
		<input type="text" id="designation" name="designation[]" required>

		<label for="quantite">Quantité :</label>
		<input type="number" id="quantite" name="quantite[]" min="1" required onchange="updatePrixTotal(this)">

		<label for="prix_unitaire">Prix unitaire :</label>
		<input type="number" id="prix_unitaire" name="prix_unitaire[]" required onchange="updatePrixTotal(this)">

		<label for="prix_total">Prix total :</label>
		<input type="number" id="prix_total" name="prix_total" required readonly>
	</div>

	<button id="ajouter_ligne"> Ajouter Ligne</button>
	<button type="submit">Créer la facture</button>
</form>