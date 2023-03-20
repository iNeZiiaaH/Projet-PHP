<?php
?>

<!doctype html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="./template/style.css">  
    </head>
    <body>
        <h1 class="text-center">Connectez Vous !</h1>
        <?php
  if (isset($_GET['error'])) {
    switch ($_GET['error']) {
      case "1":
        echo "Nom d'utilisateur ou mot de passe incorrect.";
        break;
      case "2":
        echo "Veuillez renseigner une connexion.";
        break;
      } 
    }
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
          <button type="submit" class="btn btn-dark" required>Connexion</button>
        </form> 

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
</html>