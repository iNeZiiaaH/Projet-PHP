<?php
session_start();
if(!$_SESSION['connected']){
    header('Location: login.php?error=2');
}

require_once 'Layout/header.php';
require_once 'Layout/navbar.php';
?>

