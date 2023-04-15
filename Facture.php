<?php
// Je récupère mes fonctions.
require_once 'functions/utils.php';
require_once 'functions/SessionError.php';

// Je récupère mes classes pour mes messages erreurs et succès.
require_once 'Classes/MessageError/LoginError.php';
require_once 'Classes/MessageSuccess/AddFactureSuccess.php';
require_once 'Classes/MessageError/AddFactureError.php';

// Je récupère mon header et ma navbar
require_once 'Layout/header.php';
require_once 'Layout/navbar.php';

// fonction qui redirige vers la page de connexion si l'utilisateur essaye de passer par URL sans être connecter
SessionError();

// Récupération Base de donnée 
require_once __DIR__ . '/bdd-link/bdd-link.php';

//  requête pour récuperer tous les clients de la BDD, pour la liste déroulante.
$query_View_Client = "SELECT * FROM client";
$stmt_View_Client = $pdo->prepare($query_View_Client);
$stmt_View_Client->execute();
?>

<?php
// Afficher le message que la facture a été créée
if (array_key_exists('success', $_GET)) { ?>
	<div class="alert alert-success text-center">
		<?php echo FactureSuccess::getSuccessMessage(intval($_GET['success'])); ?>
	</div>
<?php } 

// Afficher le message que le facture à bien été supprimée
if (array_key_exists('error', $_GET)) { ?>
	<div class="alert alert-danger text-center">
		<?php echo FactureError::getErrorMessage(intval($_GET['error'])); ?>
	</div>
<?php }
?>

<!-- Création du formulaire pour ajouter une facture -->
<div class="container mt-5">
	<h2 class="text-center">Ajouter une facture</h2>
	<a href="SearchFacture.php" class="btn btn-dark">Rechercher une facture</a>
	<form method="post" action="AddFacture.php">
		<div class="row mt-5">
			<div class="col-4">
				<label for="client_id" class="form-label">Client :</label>
				<!-- Liste déroulante pour afficher tous les clients dans une boucle -->
				<select name="client_id" id="client" class="form-select" required>
					<?php while ($row = $stmt_View_Client->fetch()) { ?>
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
						<!-- Je stock les données dans un tableau associatif (Lignes factures), l'index 0 signifie que dans le tableau il y auras plusieurs données et que le premier éléments est séléctionné -->
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
<script defer src="JS/UpdatePrixTotal.js"></script>
<script defer src="JS/AddInvoiceLine.js"></script>

<?php
require_once 'Layout/footer.php';