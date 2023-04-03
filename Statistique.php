<?php
require_once 'Classes/LoginError.php';
require_once 'functions/utils.php';
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

// Récupération du header et de la NavBar
require_once 'Layout/header.php';
require_once 'Layout/navbar.php'; ?>

<h1 class="text-center">Choisir le client dans la liste pour afficher le chiffre d'affaire</h1>

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
</div>

<?php

require_once 'StatistiqueProcess.php';
require_once 'Layout/footer.php';
