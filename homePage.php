<?php

require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/User/UserController.php";

// Gestion du  démarrage de la session
if (!isset($_SESSION))
{
    session_start();
}

$_SESSION['langa'] = ['fr'];

// Gestion du lancement de la connexion
if(isSubmitted()) {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    login($username, $password);
}

?>

<!DOCTYPE html>
<html lang="fr">
    <?php include $_SERVER['DOCUMENT_ROOT']."/View/html/partials/headerPartial.php" ?>
  <body>
    <div class="container-fluid container-body">
        <?php include $_SERVER['DOCUMENT_ROOT']."/View/html/partials/alertsPartial.php" ?>
      <div class="row" id="welcome">
        <div class="col-3 text-center">
          
            <?php if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) : ?>
              <a class="btn btn-primary text-center" data-toggle="collapse" href="#globalEvents" role="button" aria-expanded="false" aria-controls="globalEvents">
                Evennements géneraux
              </a>
              <div id="globalEvents" class="collapse float-left" style="max-height: 500px; overflow-y: scroll; overflow-x: hidden;">
                <?php
                  getGlobalEvents();
                ?>
              </div>
              <?php endif; ?>
        </div>
        <div class="col-6 text-center">
          <h1 class="mt-5 mb-3">Bienvenue</h1>
          <p class="p-3 icon"> <strong><i>"Wordz"</i></strong> un jeu de mot dont la consigne est : un terme va vous être présenté, vous devez entrer autant de propositions que possible conformément à la consigne. Il s'agit souvent de fournir des termes que vous associez 
            librement à celui présenté. Validez chaque proposition avec le bouton "Valider".</p>
          
            <?php if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) : ?>
              <button id='startConnectedUser-btn' type='button' class='btn btn-outline-light bg-success mt-5' onclick='redirectLoadingPage1()'>Commencer une partie</button>

              <h2 class="h2 text-center mt-5">Votre collection de termes</h2>
              <div class="d-flex justify-content-center ">
                <div class="card mb-3 bg-dark" style="width: 700px; height: 500px; max-width: 700px; max-height: 500px;">
                  <div class="row g-0">
                    <div class="col">
                      <div class="card-body">
                        <div class="box">
                          <ul class="list-group list-group-flush text-dark" style="height : 450px; overflow-y: scroll; ">
                          <?php require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/TableauTerme.php"; ?>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          <?php else : ?>
            <button id='start-btn' type='button' class='btn btn-outline-light bg-success mt-5' data-toggle='modal' data-target='#exampleModalCenter'>Commencer une partie</button>
            <!-- Modal -->
            <div class="modal fade text-dark" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalCenterTitle">Connexion</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                    <h4 class="text-center">Jeu avec compte</h4>
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
                                <small><a href="/View/html/resetPasswordPage.php">Réinitiliser le mot de passe</a></small>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary form-control">Se connecter</button>
                            </div>
                            <a class="float-right" href="/View/html/registerPage.php">S'inscrire</a>
                        </form>
                      <hr/>
                      <h4 class="text-center">Jeu sans compte</h4>
                      <form action="" method="POST">
                        <label for="language" class="d-flex align-items-center">Choix des langues <span class="text-danger"><i class="fa fa-info-circle" title="Au moins une langue doit être sélectionnée."></i></span></label>
                        <div class="form-check form-check-inline ">
                            <input class="form-check-input" type="checkbox" name="checkboxl[]" value="fr" id="flexCheckDefault1" onclick="disableBtnValidate();" checked>
                              <label class="form-check-label" for="idFr">
                                <i class="flag flag-france"></i>(FR)
                              </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="checkboxl[]" value="en" id="flexCheckDefault2" onclick="disableBtnValidate();">
                              <label class="form-check-label" for="idFr">
                                <i class="flag flag-united-kingdom"></i>(EN)
                              </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <button id="validateGuest-btn" type="button" class="btn btn-primary btn-sm" onclick="redirectLoadingPage();">Valider la(les) langue(s)</button>
                        </div>
                        <div id="alert-validate">
                        </div>
                        
                        <button id="connectGuest-btn" type="button" class="btn btn-primary form-control mt-3" data-dismiss="modal" onclick="redirectLoadingPage1();" disabled>Continuer en tant qu'invité</button>
                        
                      </form>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endif ?>
        </div>
        
        <div class="col-3 text-center">
          
          
            <?php if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) : ?>
              <a class="btn btn-primary text-center" data-toggle="collapse" href="#personalEvents" role="button" aria-expanded="false" aria-controls="personalEvents">
                Evennements personnels
              </a>
              <div id="personalEvents" class="collapse float-right" style="max-height: 500px; overflow-y: scroll; overflow-x: hidden;">
              <?php 
                getUserEvents();
              ?>
              
              </div>
              <?php endif; ?>
        </div>
      </div>
      
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT']."/View/html/partials/backgroundAnimation.php" ?>
</body>
  
<footer>

</footer>
</html>

