<?php

require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/User/UserController.php";

// Gestion du  démarrage de la session
if (!isset($_SESSION))
{
    session_start();
}

// Gestion du lancement de la connexion
if(isSubmitted()) {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    login($username, $password);
}

?>

<!DOCTYPE html>
<html lang="fr">
<?php include "partials/headerPartial.php" ?>
  <body>
    <div class="container container-body">
        <?php include "partials/alertsPartial.php" ?>
      <div class="row">
        <div class="col-2">
          
        </div>
        <div class="col-8">
          <h2 class="text-center mt-5 mb-3">Connectez-vous avec votre compte !</h2>
          <form class="border p-5" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="username">Nom utilisateur <span class="text-danger">*</span></label>
                <input type="text" class="form-control col-sm-9" id="username" name="username" value="<?php if (isset($_POST["username"])) echo $_POST["username"] ?>">
            </div>
            <div class="form-group">
                <label for="password">Mot de passe <span class="text-danger">*</span></label>
                <div class="has-feedback col-sm-6">
                    <input type="password" class="form-control" id="password" name="password">
                    <button class="btn btn-white form-control-feedback password-button" type="button" title="Affiche le mot de passe."><i class="fa fa-eye"></i></button>
                </div>
              <small><a href="/View/html/resetPasswordPage.php" class=" text-primary">Réinitiliser le mot de passe</a></small>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary form-control">Se connecter</button>
            </div>
            <a class="float-right  text-primary" href="/View/html/registerPage.php">S'inscrire</a>
          </form>
          
        </div>
        <div class="col-2">

        </div>
      </div>
    </div>
    <?php include "partials/backgroundAnimation.php" ?>
  </body>
  <footer>

  </footer>
</html>