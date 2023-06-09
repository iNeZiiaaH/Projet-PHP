<?php
require_once 'functions/utils.php';
require_once 'functions/SessionError.php';
require_once 'Classes/MessageError/LoginError.php';
require_once 'Classes/MessageSuccess/ModifyClientSuccess.php';
require_once 'Classes/MessageError/ModifyClientError.php';
require_once 'Classes/MessageError/IncompleteFields.php';

// fonction qui redirige vers la page de connexion si l'utilisateur essaye de passer par URL sans être connecter
SessionError();

// on récupère la base de donnée
require_once __DIR__ . '/bdd-link/bdd-link.php';

// on récupère id du client a modifier
$id_client = $_GET['id'];

// On récupère les données de la tables clients
$stmt = $pdo->prepare('SELECT * FROM client WHERE id = ?');
$stmt->execute([$id_client]);
$donnees_client = $stmt->fetch(PDO::FETCH_ASSOC);


// On stocks les informations du clients dans des variables pour pouvoir les afficher directement dans le formulaire pour éviter de tout réecrire les informations du client.
$email = $donnees_client['email'];
$nom = $donnees_client['nom'];
$domaine = $donnees_client['domaine'];
$adresse = $donnees_client['adresse'];
$ville = $donnees_client['ville'];
$code_postal = $donnees_client['code_postal'];
$pays = $donnees_client['pays'];


require_once 'Layout/header.php';
require_once 'Layout/navbar.php';
?>

<form class="row g-3" action="" method="POST">
    <div class="col-md-6">
        <label for="inputEmail4" class="form-label">Email</label>
        <input type="email" name="email" value="<?php echo $email ?>" class="form-control" id="inputEmail4" placeholder="echdinjove@bjrcn.com">
    </div>
    <div class="col-md-6">
        <label for="inputNom" class="form-label">Nom</label>
        <input type="text" name="nom" value="<?php echo $nom ?>" class="form-control" id="inputNom" placeholder="Nom Entreprise">
    </div>
    <div class="col-12">
        <label for="inputDomaine" class="form-label">Domaine</label>
        <input type="text" name="domaine" value="<?php echo $domaine ?>" class="form-control" id="inputDomaine" placeholder="Domaine activité">
    </div>
    <div class="col-12">
        <label for="inputAdress" class="form-label">Adresse</label>
        <input type="text" name="adresse" value="<?php echo $adresse ?>" class="form-control" id="inputAdress" placeholder="12 rue saint felicien">
    </div>
    <div class="col-md-6">
        <label for="inputCity" class="form-label">Ville</label>
        <input type="text" name="ville" value="<?php echo $ville ?>" class="form-control" id="inputVille">
    </div>
    <div class="col-md-4">
        <label for="inputCodePostal" class="form-label">Code postal</label>
        <input type="number" name="code_postal" class="form-control" id="inputCodePostal" value=<?php echo $code_postal ?>>
    </div>
    <div class="col-md-4">
        <label for="inputPays" class="form-label">Pays</label>
        <input type="text" name="pays" value="<?php echo $pays ?>" class="form-control" id="inputPays">
    </div>
    <div class="col-12">
        <button type="submit" name="modifier_client" class="btn btn-dark">Modifier</button>
    </div>
</form>

<?php
require_once 'ModifyClientProcess.php';

// affichage de modification du client réusssie
if (array_key_exists('success', $_GET)) { ?>
    <div class="alert alert-success text-center">
        <?php echo ModifyClientSuccess::getSuccessMessage(intval($_GET['success'])); ?>
    </div>
<?php }

// affichage d'erreur si la modification du client a échouer
if (array_key_exists('error', $_GET)) { ?>
    <div class="alert alert-danger text-center">
        <?php echo ModifyClientError::getErrorMessage(intval($_GET['error'])); ?>
    </div>
<?php }

// Message erreur si tous les champs ne sont pas renseigner
if (array_key_exists('error', $_GET)) { ?>
    <div class="alert alert-danger text-center">
        <?php echo IncompleteFields::getErrorMessage(intval($_GET['error'])); ?>
    </div>
<?php }

require_once 'Layout/footer.php';
