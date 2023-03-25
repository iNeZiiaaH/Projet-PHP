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

<!-- Pour calculer le montant total de la facture en fonction des prix unitaires de chaque description, j'effectue du JS
<script>
	const prixUnitaires = document.querySelectorAll('input[name="prix_unitaire[]"]');
	let montant = 0;
	prixUnitaires.forEach(prixUnitaires => {
		total += parseFloat(prixUnitaires.value);
	}) 
</script> -->