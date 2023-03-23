<?php
require_once 'functions/utils.php';
// Récupération des classes pour les erreurs et les succès
require_once 'Classes/LoginError.php';
require_once 'Classes/LoginSuccess.php';

// condition qui dis que si utilisateur n'est pas connecté alors il est renvoyé vers la page login.php
session_start();
if (!$_SESSION['connected']) {
    redirect('login.php?error=' . LoginError::CONNECTION_FAILED);
}

require_once 'Layout/header.php';
require_once 'Layout/navbar.php'; ?>

<h1 class="text-center">BIENVENUE</h1>

<?php if (array_key_exists('success', $_GET)) { ?>
    <div class="alert alert-success text-center">
        <?php echo LoginSuccess::getSuccessMessage(intval($_GET['success'])); ?>
    </div>
<?php }

require_once 'Layout/footer.php';
