<?php
// je récupère ma classe ViewClient
require_once 'Classes/ClientCrud.php';

// on crée une instance de la classe ViewClient
$client = new ClientCrud($pdo);

if (isset($_GET['id'])) {
    echo $client->afficherClient($_GET['id']); ?>

    <div class="card d-flex mx-auto mt-5" style="width: 18rem;">
        <div class="card-body text-center">
            <h5 class="card-title">Client : <?php echo $client->getNom(); ?></h5>
            <p class="card-text">Email : <?php echo  $client->getEmail() ?></p>
            <p class="card-text">Activité : <?php echo $client->getDomaine() ?></p>
            <p class="card-text">Adresse : <?php echo $client->getAdresse() ?></p>
            <p class="card-text">Ville : <?php echo $client->getVille() ?></p>
            <p class="card-text">Code-Postal : <?php echo $client->getCodePostal() ?></p>
            <p class="card-text">Pays : <?php echo $client->getPays() ?></p>
            <a href="ModifyClient.php?id=<?php echo $client->getId(); ?>" class="btn btn-dark">Modifier Client</a>
            <br></br>
            <a href="DeleteClient.php?id=<?php echo $client->getId(); ?>" class="btn btn-dark">Supprimer Client</a>
        </div>
    </div>
<?php }
