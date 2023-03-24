<?php
require_once 'functions/utils.php';
require_once 'Classes/LoginError.php';
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

// Récupération du header et de la NavBar
require_once 'Layout/header.php';
require_once 'Layout/navbar.php'; ?>

<h1 class="text-center">Choisir le client dans la liste</h1>

<div class="d-flex justify-content-center mt-5 ">
  <form action="" method="get" class="d-flex gap-3 w-50">
    <select name="id" class="form-select" aria-label="Default select example">
      <option selected>Sélectionner un Client</option>
      <?php while ($row = $stmt->fetch()) { ?>
        <option value="<?php echo $row['id']; ?>"><?php echo $row['nom']; ?></option>
      <?php } ?>
    </select>
    <button type="submit" class="btn btn-dark">Rechercher</button>
  </form>
  <button type="button" class="btn btn-outline-dark" onclick="location='Add-Client.php ';">Ajouter Client</button>
</div>

<?php
// condition pour que la reqête s'execute que si le client est renseigné
if (isset($_GET['id'])) {

  $clientId = $_GET['id'];

  $query = "SELECT * FROM client WHERE id=:id";
  $stmt = $pdo->prepare($query);
  $stmt->execute([
    'id' => $clientId
  ]);
  $client = $stmt->fetch();

  //  condition si aucun client n'est trouvé
  if ($client === false) {
    http_response_code(404);
    exit('Client non trouvé');
  } ?>

  <div class="card d-flex mx-auto mt-5" style="width: 18rem;">
    <div class="card-body text-center">
      <h5 class="card-title"><?php echo $client['nom']; ?></h5>
      <p class="card-text"><?php echo $client['email'] ?></p>
      <p class="card-text"><?php echo $client['domaine'] ?></p>
      <p class="card-text"><?php echo $client['adresse'] ?></p>
      <p class="card-text"><?php echo $client['ville'] ?></p>
      <p class="card-text"><?php echo $client['code_postal'] ?></p>
      <p class="card-text"><?php echo $client['pays'] ?></p>
      <a href="ModifyClient.php?id=<?php echo $client['id']; ?>" class="btn btn-dark">Modifier Client</a>
      <br></br>
      <a href="DeleteClient.php?id=<?php echo $client['id']; ?>" class="btn btn-dark">Supprimer Client</a>
    </div>
  </div>
<?php }
require_once 'Layout/footer.php';
