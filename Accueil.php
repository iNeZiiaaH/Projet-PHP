<?php
session_start();
if(!$_SESSION['connected']){
    header('Location: login.php?error=2');
}

require_once 'Layout/header.php';
require_once 'Layout/navbar.php'; ?>
        <h1 class="text-center">BIENVENUE</h1>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
</html>