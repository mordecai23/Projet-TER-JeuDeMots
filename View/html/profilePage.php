<?php

require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/User/UserController.php";
require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/User/UserQueries.php";

// Gestion du  démarrage de la session
if (!isset($_SESSION))
{
    session_start();
}

// Gestion du lancement de la connexion
if(isSubmitted()) {
  
    $avatarSrc = "/View/images/".trim($_POST["avatar"]).".jpg";
    $userId = $_SESSION["userId"];
    $username = trim($_POST["username"]);
    $emailAddress = trim($_POST["email"]);
    $languages = $_POST["languages"];

    profile($avatarSrc, $userId, $username, $emailAddress, $languages);
}
else
{
    $languages = getUserLanguages($_SESSION["userId"]);
    $savedPassword = getSavedPasswordById($_SESSION["userId"]);

    $isGoogleAccount = password_verify("NONE", $savedPassword);
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
            <h2 class="text-center mt-5 mb-3">Profil</h2>
            <form class="row g-2 border p-5" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

                <div class="form-group" style="margin: auto; width: 180px; height: auto;">
                  <div id="carouselAvatar" class="carousel slide carousel-fade" data-ride="carousel" data-interval="false">
                    <div class="carousel-inner">
                      <div class="carousel-item" id="avatar1">
                        <img src="/View/images/avatar1.jpg" width="170px" height="180px" alt="Avatar 1">
                      </div>
                      <div class="carousel-item" id="avatar2">
                        <img src="/View/images/avatar2.jpg" width="170px" height="180px" alt="Avatar 2">
                      </div>
                      <div class="carousel-item" id="avatar3">
                        <img src="/View/images/avatar3.jpg" width="170px" height="180px" alt="Avatar 3">
                      </div>
                      <div class="carousel-item" id="avatar4">
                        <img src="/View/images/avatar4.jpg" width="170px" height="180px" alt="Avatar 4">
                      </div>
                      <div class="carousel-item" id="avatar5">
                        <img src="/View/images/avatar5.jpg" width="170px" height="180px" alt="Avatar 5">
                      </div>
                      <div class="carousel-item" id="avatar6">
                        <img src="/View/images/avatar6.jpg" width="170px" height="180px" alt="Avatar 6">
                      </div>
                      <div class="carousel-item" id="avatar7">
                        <img src="/View/images/avatar7.jpg" width="170px" height="180px" alt="Avatar 7">
                      </div>
                      <div class="carousel-item" id="avatar8">
                        <img src="/View/images/avatar8.jpg" width="170px" height="180px" alt="Avatar 8">
                      </div>
                      <div class="carousel-item" id="avatar9">
                        <img src="/View/images/avatar9.jpg" width="170px" height="180px" alt="Avatar 9">
                      </div>
                      <div class="carousel-item" id="avatar10">
                        <img src="/View/images/avatar10.jpg" width="170px" height="180px" alt="Avatar 10">
                      </div>
                      <div class="carousel-item" id="avatar11">
                        <img src="/View/images/avatar11.jpg" width="170px" height="180px" alt="Avatar 11">
                      </div>
                    </div>
                    <a class="carousel-control-prev text-dark" href="#carouselAvatar" role="button" data-slide="prev">
                      <i class="fa fa-arrow-left" aria-hidden="true"></i>
                      <span class="sr-only">Précédent</span>
                    </a>
                    <a class="carousel-control-next text-dark" href="#carouselAvatar" role="button" data-slide="next">
                      <i class="fa fa-arrow-right" aria-hidden="true"></i>
                      <span class="sr-only">Suivant</span>
                    </a>
                  </div>
                  <input type="text" class="form-control invisible" id="avatar" name="avatar" value="">
                </div>

                <?php if (!$isGoogleAccount) : ?>
                    <div class="form-group">
                        <label for="username">Nom utilisateur <span class="text-danger">*</span></label>
                        <input type="text" class="form-control col-sm-9" id="username" placeholder="20 caractères max." maxlength="20" name="username" value="<?php if (isset($_POST["username"])) echo $_POST["username"] ?>">
                        <span class="text-danger"><?php if (isset($_GET["usernameError"])) echo $_GET["usernameError"] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Adresse email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control col-sm-9" id="email" name="email" value="<?php if (isset($_POST["email"])) echo $_POST["email"] ?>">
                        <span class="text-danger"><?php if (isset($_GET["emailError"])) echo $_GET["emailError"] ?></span>
                    </div>
                <?php endif ?>

                <div class="form-group">
                    <label for="language">Choix des langues <span class="text-danger"><i class="fa fa-info-circle" title="Au moins une langue doit être sélectionnée."></i></span></label>
                </div>
                <div class="col-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="languages[]" value="fr" id="idFr"
                            <?php
                            if(empty($languages) || in_array("fr", $languages)) {
                                echo "checked";
                            }
                            ?>
                        >
                        <label class="form-check-label" for="idFr">
                            <i class="flag flag-france"></i>(FR)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="languages[]" value="en" id="idEn"
                            <?php
                            if(!empty($languages) && in_array("en", $languages)) {
                                echo "checked";
                            }
                            ?>
                        >
                        <label class="form-check-label" for="idEn">
                            <i class="flag flag-united-kingdom"></i>(EN)
                        </label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="languages[]" value="es" id="idEs"
                            <?php
                            if(empty($languages) || in_array("es", $languages)) {
                                echo "checked";
                            }
                            ?>
                        >
                        <label class="form-check-label" for="idEs">
                            <i class="flag flag-spain"></i>(ES)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="languages[]" value="it" id="idIt"
                            <?php
                            if(!empty($languages) && in_array("it", $languages)) {
                                echo "checked";
                            }
                            ?>
                        >
                        <label class="form-check-label" for="idIt">
                            <i class="flag flag-italy"></i>(IT)
                        </label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="languages[]" value="ru" id="idRu"
                            <?php
                            if(empty($languages) || in_array("ru", $languages)) {
                                echo "checked";
                            }
                            ?>
                        >
                        <label class="form-check-label" for="idRu">
                            <i class="flag flag-russia"></i>(RU)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="languages[]" value="zh" id="idZh"
                            <?php
                            if(!empty($languages) && in_array("zh", $languages)) {
                                echo "checked";
                            }
                            ?>
                        >
                        <label class="form-check-label" for="idZh">
                            <i class="flag flag-china"></i>(ZH)
                        </label>
                    </div>
                </div>
                <span class="text-danger">
                  <?php if (isset($_GET["languagesError"]))  echo $_GET["languagesError"] ?>
                </span>
                <div class="col-12 mt-3">
                  <button type="submit" class="btn btn-primary form-control">Modifier</button>
                  <a href="/View/html/changePassword.php"><small>Modifier mon mot de passe</small></a>
                </div>
            </form>
            <script>

              /**
               * Affichage des informations par défauts de l'utilisateur.
               */
              var currentAvatar = '<?php echo $_SESSION['avatarSrc'];?>';
              var currentUsername = '<?php echo $_SESSION['username'];?>';
              var currentEmail = '<?php echo $_SESSION['emailUser'];?>';
              
              var tabSplitUrlAvatar = currentAvatar.split(".jpg");
              
              var tabSplitUrlAvatar2 = tabSplitUrlAvatar[0].split("/");

              document.getElementById(tabSplitUrlAvatar2[3]).className = "carousel-item active";

              var elemUsername = document.getElementById("username");
              var elemEmail = document.getElementById("email");

              if (elemUsername||elemEmail) {
                elemUsername.value = currentUsername;
                elemEmail.value = currentEmail;
              }

              /**
               * Récupération avatar dans l'inscription
               */
              var currentIndex = $('div.active').index() + 1;
              var av = "avatar"+parseInt(currentIndex, 10);
              document.getElementById("avatar").value = av; 
              
              $('#carouselAvatar').bind('slid.bs.carousel', function() {
                currentIndex = $('div.active').index() + 1;
                av = "avatar"+parseInt(currentIndex, 10);
                document.getElementById("avatar").value = av; 
              });

              
            </script>
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
