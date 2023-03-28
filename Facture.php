<?php
require_once 'functions/utils.php';
require_once 'Classes/LoginError.php';
require_once 'Classes/AddFactureSuccess.php';
require_once 'Classes/AddFactureError.php';


require_once 'Layout/header.php';
require_once 'Layout/navbar.php';

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

<h2 class="text-center">Ajouer une facture</h2>
<form method="POST" action="AddFacture.php">

	<div id="champs-container">
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
		<input type="number" id="quantite" name="quantite" min="1" required onchange="updatePrixTotal(this)">

		<label for="prix_unitaire">Prix unitaire :</label>
		<input type="number" id="prix_unitaire" name="prix_unitaire" required onchange="updatePrixTotal(this)">

		<label for="prix_total">Prix total :</label>
		<input type="number" id="prix_total" name="prix_total" required readonly>
	</div>

	<button id="ajouter_ligne"> Ajouter Ligne</button>
	<button type="submit">Créer la facture</button>
</form>

<?php
// Afficher le message que la facture a été crée
if (array_key_exists('success', $_GET)) { ?>
	<div class="alert alert-success text-center">
		<?php echo FactureSuccess::getSuccessMessage(intval($_GET['success'])); ?>
	</div>
<?php }

// Afficher le message que le facture à bien été supprimé
if (array_key_exists('error', $_GET)) { ?>
	<div class="alert alert-danger text-center">
		<?php echo FactureError::getErrorMessage(intval($_GET['error'])); ?>
	</div>
<?php }
?>

<a href="SearchFacture.php" class="btn btn-dark mt-5">Rechercher une facture</a>

<script>
	function updatePrixTotal() {
		var quantite = document.getElementById("quantite").value;
		var prix_unitaire = document.getElementById("prix_unitaire").value;
		var prix_total = quantite * prix_unitaire;
		document.getElementById("prix_total").value = prix_total;
	}

	// // on récupère le bouton pour ajouter les lignes
	// const btnAjouterChamp = document.querySelector("#ajouter_ligne");

	// // on récupère la div 
	// const champsContainer = document.querySelector("#champs-container");

	// btnAjouterChamp.addEventListener("click", function() {
	// 	// on vient crée les nouveau champs 
	// 	const champDesignation = document.createElement("input");
	// 	champDesignation.type = "texte";
	// 	champDesignation.name = "designation[]";

	// 	const champQuantite = document.createElement("input");
	// 	champQuantite.type = "number";
	// 	champQuantite.name = "quantite[]";

	// 	const champPrixUnitaire = document.createElement("input");
	// 	champPrixUnitaire.type = "number";
	// 	champPrixUnitaire.name = "prix_unitaire[]";

	// 	// on ajoute les nouveaux champs au container 
	// 	champsContainer.appendChild(champDesignation);
	// 	champsContainer.appendChild(champQuantite);
	// 	champsContainer.appendChild(champPrixUnitaire);
	// });

</script>