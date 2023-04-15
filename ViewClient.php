<?php
// je récupère ma classe ClientCrud pour récupèrer la méthode pour afficher les clients.
require_once 'Classes/ClientCrud.php';

// on crée une instance de la classe ViewClient
$InfoClient = new ClientCrud($pdo);

if (isset($_GET['id'])) {
    // Je récupère la méthode pour afficher les clients.
    echo $InfoClient->ViewClient($_GET['id']); ?>

<!-- J'affiche les clients sous forme de carte avec toutes les informations de chaque client et je rajoute deux boutons un pour le modifier et un autre pour le supprimer. -->
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
