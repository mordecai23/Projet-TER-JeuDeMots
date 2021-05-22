<?php
  if (!isset($_SESSION)) { session_start(); }
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
                        <label for="newPassword1">Nouveau mot de passe</label>
                        <input type="password" class="form-control" id="newPassword1" placeholder="Nouveau mot de passe">
                    </div>
                    <div class="form-group">
                        <label for="newPassword2">Confirmation mot de passe</label>
                        <input type="password" class="form-control" id="newPassword2" placeholder="Confirmation mot de passe">
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary form-control" onclick="window.location.href = '/homePage.php';">Modifier mot de passe</button>
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

