<?php



// Récupération Base de donnée 
require_once 'bdd-link/bdd-link.php';

//  requête pour récuperer tous les clients de la BDD
$query = "SELECT * FROM client";
$stmt = $pdo->prepare($query);
$stmt->execute();

require_once 'Layout/header.php';
require_once 'Layout/navbar.php';
?>

<h2 class="text-center">Rechercher une facture par client</h2>

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
require_once 'SearchFactureProcess.php';
require_once 'Layout/footer.php';
