<?php

require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/User/UserController.php";

// Gestion du  démarrage de la session
if (!isset($_SESSION))
{
    session_start();
}

// Gestion du lancement de la réinitialisation du mot de passe
if(isSubmitted()) {

    $emailAddress = trim($_POST["email"]);

    resetPassword($emailAddress);
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
                <h2 class="text-center mt-5 mb-3">Vérification par mail</h2>
                <form class="form border p-5" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="form-group">
                        <label for="email">Adresse email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control col-sm-9" id="email" name="email" value="<?php if (isset($_POST["email"])) echo $_POST["email"] ?>">
                        <span class="text-danger"><?php if (isset($_GET["emailError"])) echo $_GET["emailError"] ?></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary form-control">Envoyer</button>
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

