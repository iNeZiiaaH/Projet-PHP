<?php
require_once 'functions/utils.php';
require_once 'functions/SessionError.php';
require_once 'Classes/MessageError/LoginError.php';
require_once 'Classes/MessageError/AddClientError.php';
require_once 'Classes/MessageSuccess/AddClientSuccess.php';

// fonction qui redirige vers la page de connexion si l'utilisateur essaye de passer par URL sans être connecter
SessionError();

require_once 'Layout/header.php';
require_once 'Layout/navbar.php';
?>

<form class="row g-3" action="Add-Client-process.php" method="POST">
    <div class="col-md-6">
        <label for="inputEmail4" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" id="inputEmail4" placeholder="echdinjove@bjrcn.com" required>
    </div>
    <div class="col-md-6">
        <label for="inputNom" class="form-label">Nom</label>
        <input type="text" name="nom" class="form-control" id="inputNom" placeholder="Erwan" maxlength="30" required>
    </div>
    <div class="col-12">
        <label for="inputDomaine" class="form-label">Domaine</label>
        <input type="text" name="domaine" class="form-control" id="inputDomaine" placeholder="Domaine activité" maxlength="30" required>
    </div>
    <div class="col-12">
        <label for="inputAdress" class="form-label">Adresse</label>
        <input type="text" name="adresse" class="form-control" id="inputAdress" placeholder="12 rue saint felicien" required>
    </div>
    <div class="col-md-6">
        <label for="inputCity" class="form-label">Ville</label>
        <input type="text" name="ville" class="form-control" id="inputVille" placeholder="Lyon" required>
    </div>
    <div class="col-md-4">
        <label for="inputCodePostal" class="form-label">Code postal</label>
        <input type="number" name="code_postal" class="form-control" id="inputCodePostal" placeholder="00000" maxlength="5" required>
    </div>
    <div class="col-md-4">
        <label for="inputPays" class="form-label">Pays</label>
        <input type="text" name="pays" class="form-control" id="inputPays" placeholder="France" required>
    </div>
    <div class="col-12">
        <button type="submit" value="Connexion" class="btn btn-dark">Ajouter</button>
    </div>
</form>

<?php if (array_key_exists('success', $_GET)) { ?>
    <div class="alert alert-success text-center">
        <?php echo ClientSuccess::getSuccessMessage(intval($_GET['success'])); ?>
    </div>
<?php }

if (array_key_exists('error', $_GET)) { ?>
    <div class="alert alert-danger text-center">
        <?php echo ClientErro::getErrorMessage(intval($_GET['error'])); ?>
    </div>
<?php }

require_once 'Layout/footer.php'; ?>