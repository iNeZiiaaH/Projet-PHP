<?php
// condition qui dis que si utilisateur n'est pas connecté alors il est renvoyé vers la page login.php
session_start();
if(!$_SESSION['connected']){
    header('Location: login.php?error=2');
}
// Récupération Base de donnée 
require_once 'bdd-link/bdd-link.php';

//  requête pour récuperer tous les clients de la BDD
$query= "SELECT * FROM client";
$stmt = $pdo->prepare($query);
$stmt->execute();

// Récupération du header et de la NavBar
require_once 'Layout/header.php';
require_once 'Layout/navbar.php'; ?>

<h1 class="text-center">Choisir le client dans la liste</h1>

<form action="" method="get">
  <select name="id">
    <?php while ($row = $stmt->fetch()) { ?>
      <option value="<?php echo $row['id']; ?>">
      <?php echo $row['nom']; ?>
      </option>
      <?php } ?>
  </select>
  <button type="submit" class="btn btn-dark">Rechercher</button>
</form>

<div class="d-flex justify-content-end mx-5">
  <button type="button" class="btn btn-outline-secondary btn-lg" onclick="location='Add-Client.php ';">Modifier Un Client</button>
  <button type="button" class="btn btn-outline-secondary btn-lg" onclick="location='Add-Client.php ';">Ajouter Client</button>
</div>

<?php

      $clientId = $_GET['id'];

      // Je me sers de mon clientId pour exécuter une requête SQL
      $query= "SELECT * FROM client WHERE id=$clientId";
      $stmt = $pdo->prepare($query);
      $stmt->execute();
      $client = $stmt->fetch(); 
      
      //  condition si aucun client n'est trouvé
      if ($client === false) {
        http_response_code(404);
        exit('Produit non trouvé');
      }
      ?>
      <!-- Affichage des informations des clients  -->
      <h1><?php echo $client['nom']; ?></h1>
      <h2><?php echo $client['domaine']; ?></h2>
      <h2><?php echo $client['adresse']; ?></h2>
      <h2><?php echo $client['ville']; ?></h2>
      <h2><?php echo $client['code_postal']; ?></h2>
      <h2><?php echo $client['pays']; ?></h2>
    <?php require_once 'Layout/footer.php';