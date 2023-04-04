<?php
// Récupération des fonctions
require_once 'functions/utils.php';
require_once 'functions/SessionError.php';

// Récupération des classes pour les erreurs et les succès
require_once 'Classes/MessageError/LoginError.php';
require_once 'Classes/MessageSuccess/LoginSuccess.php';

// fonction qui redirige vers la page de connexion si l'utilisateur essaye de passer par URL sans être connecter
SessionError();

require_once 'bdd-link/bdd-link.php';

require_once 'Layout/header.php';
require_once 'Layout/navbar.php'; ?>

<h1 class="text-center">BIENVENUE</h1>

<?php
if (array_key_exists('success', $_GET)) { ?>
    <div class="alert alert-success text-center">
        <?php echo LoginSuccess::getSuccessMessage(intval($_GET['success'])); ?>
    </div>
<?php }

require_once 'Layout/footer.php';
