<?php
require_once 'Classes/MessageError/LoginError.php';
require_once 'functions/utils.php';
require_once 'functions/SessionError.php';
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
