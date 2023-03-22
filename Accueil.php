<?php
require_once 'Classes/LoginError.php';
session_start();
if(!$_SESSION['connected']){
    header('location: login.php?error=' . LoginError::CONNECTION_FAILED);
}

require_once 'Layout/header.php';
require_once 'Layout/navbar.php'; ?>
        <h1 class="text-center">BIENVENUE</h1>
<?php
require_once 'Layout/footer.php';