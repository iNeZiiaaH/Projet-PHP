<?php
require_once 'Classes/LoginError.php';

// condition qui dis que si utilisateur n'est pas connecté alors il est renvoyé vers la page login.php
session_start();
if (!$_SESSION['connected']) {
    header('location: login.php?error=' . LoginError::CONNECTION_FAILED);
}

require_once 'Layout/header.php';
require_once 'Layout/navbar.php';
?>

<form class="row g-3" action="Add-Client-process.php" method="POST">
    <div class="col-md-6">
        <label for="inputEmail4" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" id="inputEmail4" placeholder="echdinjove@bjrcn.com">
    </div>
    <div class="col-md-6">
        <label for="inputNom" class="form-label">Nom</label>
        <input type="text" name="nom" class="form-control" id="inputNom" placeholder="Erwan">
    </div>
    <div class="col-12">
        <label for="inputDomaine" class="form-label">Domaine</label>
        <input type="text" name="domaine" class="form-control" id="inputDomaine" placeholder="Domaine activité">
    </div>
    <div class="col-12">
        <label for="inputAdress" class="form-label">Adresse</label>
        <input type="text" name="adresse" class="form-control" id="inputAdress" placeholder="12 rue saint felicien">
    </div>
    <div class="col-md-6">
        <label for="inputCity" class="form-label">Ville</label>
        <input type="text" name="ville" class="form-control" id="inputVille">
    </div>
    <div class="col-md-4">
        <label for="inputCodePostal" class="form-label">Code postal</label>
        <input type="text" name="code_postal" class="form-control" id="inputCodePostal">
    </div>
    <div class="col-md-4">
        <label for="inputPays" class="form-label">Pays</label>
        <input type="text" name="pays" class="form-control" id="inputPays">
    </div>
    <div class="col-12">
        <button type="submit" value="Connexion" class="btn btn-dark">Ajouter</button>
    </div>
</form>