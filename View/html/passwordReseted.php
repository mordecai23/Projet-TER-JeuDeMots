<?php
require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/User/UserController.php";

// Gestion du  démarrage de la session
if (!isset($_SESSION))
{
    session_start();
}

// Gestion du lancement de la réinitialisation du mot de passe
if(isSubmitted()) {

    $code = $_GET["code"];
    $userId = $_GET["userId"];
    $newPassword = trim($_POST["newPassword"]);
    $passwordConfirmation = trim($_POST["passwordConfirmation"]);

    passwordReseted($userId, $code, $newPassword, $passwordConfirmation);
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
            <h2 class="text-center mt-5 mb-3">Réinitialisation mot de passe</h2>
            <form class="border p-5" action="" method="POST">
                <div class="form-group">
                    <label for="password">Nouveau mot de passe <span class="text-danger">*</span></label>
                    <div class="has-feedback col-sm-6">
                        <input type="password" class="form-control" id="newPassword" name="newPassword">
                        <button class="btn btn-white form-control-feedback password-button" type="button" title="Affiche le mot de passe."><i class="fa fa-eye"></i></button>
                    </div>
                    <span class="text-danger"><?php if (isset($_GET["newPasswordError"])) echo $_GET["newPasswordError"] ?></span>
                </div>
                <div class="form-group">
                    <label for="passwordConfirmation">Confirmation de mot de passe <span class="text-danger">*</span></label>
                    <div class="has-feedback col-sm-6">
                        <input type="password" class="form-control" id="passwordConfirmation" name="passwordConfirmation">
                        <button class="btn btn-white form-control-feedback password-button" type="button" title="Affiche le mot de passe."><i class="fa fa-eye"></i></button>
                    </div>
                    <span class="text-danger"><?php if (isset($_GET["passwordConfirmationError"])) echo $_GET["passwordConfirmationError"] ?></span>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary form-control">Réinitialiser</button>
                </div>
            </form>
        </div>
        <div class="col">

        </div>
    </div>
</div>
<?php include "partials/backgroundAnimation.php" ?>
</body>
<footer>
</footer>
</html>

