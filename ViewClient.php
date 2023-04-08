<?php
// je récupère ma classe ViewClient
require_once 'Classes/ClientCrud.php';

// on crée une instance de la classe ViewClient
$InfoClient = new ClientCrud($pdo);

if (isset($_GET['id'])) {
    echo $InfoClient->ViewClient($_GET['id']); ?>

    <div class="card d-flex mx-auto mt-5" style="width: 18rem;">
        <div class="card-body text-center">
            <h5 class="card-title">Client : <?php echo $InfoClient->getNom() ?></h5>
            <p class="card-text">Email : <?php echo  $InfoClient->getEmail() ?></p>
            <p class="card-text">Activité : <?php echo $InfoClient->getDomaine() ?></p>
            <p class="card-text">Adresse : <?php echo $InfoClient->getAdresse() ?></p>
            <p class="card-text">Ville : <?php echo $InfoClient->getVille() ?></p>
            <p class="card-text">Code-Postal : <?php echo $InfoClient->getCodePostal() ?></p>
            <p class="card-text">Pays : <?php echo $InfoClient->getPays() ?></p>
            <a href="ModifyClient.php?id=<?php echo $InfoClient->getId(); ?>" class="btn btn-dark">Modifier Client</a>
            <br></br>
            <a href="DeleteClient.php?id=<?php echo $InfoClient->getId(); ?>" class="btn btn-dark">Supprimer Client</a>
        </div>
    </div>
<?php }
