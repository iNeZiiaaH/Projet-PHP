<?php
// Je récupère mes fonctions redirect et session error.
require_once 'functions/utils.php';
require_once 'functions/SessionError.php';

// Je récupère mes classes pour les messages erreurs et de succès.
require_once 'Classes/MessageError/LoginError.php';
require_once 'Classes/MessageSuccess/DeleteClientSuccess.php';

// fonction qui redirige vers la page de connexion si l'utilisateur essaye de passer par URL sans être connecter
SessionError();

// Récupération Base de donnée 
require_once __DIR__ . '/bdd-link/bdd-link.php';

// requête pour récuperer tous les clients de la BDD pour la liste déroulante
$query = "SELECT * FROM client";
$stmt = $pdo->prepare($query);
$stmt->execute();

// Récupération du header et de la NavBar
require_once 'Layout/header.php';
require_once 'Layout/navbar.php'; ?>

<h1 class="text-center">Choisir le client dans la liste</h1>

<div class="d-flex justify-content-center mt-5 gap-3">
  <form action="" method="get" class="d-flex gap-3 w-50">
    <select name="id" class="form-select" aria-label="Default select example">
      <option selected>Sélectionner un Client</option>
      <!-- Boucle pour récupèrer tous les clients grâce à la requête que j'ai effectué plus haut. -->
      <?php while ($row = $stmt->fetch()) { ?>
        <option value="<?php echo $row['id']; ?>"><?php echo $row['nom']; ?></option>
      <?php } ?>
    </select>
    <button type="submit" class="btn btn-dark">Rechercher</button>
  </form>
  <button type="button" class="btn btn-dark" onclick="location='Add-Client.php ';">Ajouter Client</button>
</div>

<!-- Je rèécupère ma méthode pour afficher les clients. -->
<?php require_once 'ViewClient.php';

// Afficher le message que le client à bien été supprimé
if (array_key_exists('success', $_GET)) { ?>
  <div class="alert alert-success text-center">
    <?php echo DeleteClientSuccess::getSuccessMessage(intval($_GET['success'])); ?>
  </div>
<?php }

require_once 'Layout/footer.php';
