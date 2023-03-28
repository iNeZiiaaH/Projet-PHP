<?php
require_once 'functions/utils.php';
require_once 'Classes/LoginError.php';


require_once 'Layout/header.php';
require_once 'Layout/navbar.php';

// condition qui dis que si utilisateur n'est pas connecté alors il est renvoyé vers la page login.php
session_start();
if (!$_SESSION['connected']) {
	redirect('login.php?error=' . LoginError::CONNECTION_FAILED);
}
// Récupération Base de donnée 
require_once 'bdd-link/bdd-link.php';

//  requête pour récuperer tous les clients de la BDD
$query = "SELECT * FROM client";
$stmt = $pdo->prepare($query);
$stmt->execute();
?>

<form method="POST" action="AddFacture.php">

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

	<label for="designation">Designation : </label>
	<input type="text" id="designation" name="designation" required>

	<label for="quantite">Quantité :</label>
	<input type="number" id="quantite" name="quantite" min="1" required onchange="updatePrixTotal()">

	<label for="prix_unitaire">Prix unitaire :</label>
	<input type="number" id="prix_unitaire" name="prix_unitaire" required onchange="updatePrixTotal()">

	<!-- <button type="button" id="ajouter_ligne" onclick="ajouterLigne()">Ajouter une ligne</button> -->

	<label for="prix_total">Prix total :</label>
	<input type="number" id="prix_total" name="prix_total" required readonly>

	</table>


	<button type="submit">Créer la facture</button>
</form>



<script>
	function updatePrixTotal() {
		var quantite = document.getElementById("quantite").value;
		var prix_unitaire = document.getElementById("prix_unitaire").value;
		var prix_total = quantite * prix_unitaire;
		document.getElementById("prix_total").value = prix_total;
	}
</script>