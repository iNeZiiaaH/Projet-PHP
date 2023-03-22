<?php

require_once 'Classes/LoginError.php';
require_once 'Classes/LoginSuccess.php';
require_once 'Layout/header.php'; ?>


<h1 class="text-center">Connectez Vous !</h1>

<?php if (array_key_exists('error', $_GET)) { ?>
  <div class="alert alert-danger text-center">
    <?php echo LoginError::getErrorMessage(intval($_GET['error'])); ?>
  </div>
  <?php } ?>

</div>
<form class="row col-lg-4 mx-auto mt-5 text-center" method="post" action="login-process.php">
  <div class="mb-3">
    <label class="form-label">Login</label>
    <input type="text" class="form-control" name="login" required>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Mot de passe</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="pass" required>
  </div>
  <button type="submit" class="btn btn-dark" required>Connexion</button>
</form>




<?php require_once 'Layout/footer.php';
