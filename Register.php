<?php

require_once 'Layout/header.php';
?>

<form class="row col-lg-4 mx-auto mt-5 text-center" method="post" action="login-process.php">
    <div class="mb-3">
        <label class="form-label">Login</label>
        <input type="text" class="form-control" name="login" required>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="exampleInputPassword1" name="pass" required>
    </div>
    <button type="submit" class="btn btn-dark" required>S'inscrire</button>
</form>