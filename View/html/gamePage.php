<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/User/UserQueries.php";

  if (!isset($_SESSION)) { session_start(); }

  if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true){
    $wordCounter = 10 + getUserLevel($_SESSION["userId"]);

    if ($wordCounter > 25) {
        $wordCounter = 25;
    }

  } else {
    $wordCounter = 10;
  }
    

?>
<!DOCTYPE html>
<html lang="fr">
  <?php include "partials/headerPartial.php" ?>
  <?php if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) : ?>
    <script type="text/javascript">
     document.addEventListener('contextmenu', event => event.preventDefault());
      /**
       * Grisage des boutons modification de profil et déconnexion en mode connecté
       */
      var user = document.getElementById("profil-image-link");
      var profil = document.getElementById("profil-link");
      var disconnect = document.getElementById("disconnect-link");

      user.setAttribute("class", "nav-link d-sm-flex align-items-sm-center disabled");
      profil.setAttribute("class", "dropdown-item disabled");
      disconnect.setAttribute("class", "dropdown-item disabled");
    </script>
  <?php else : ?>
    <script type="text/javascript">
     document.addEventListener('contextmenu', event => event.preventDefault());
      /**
       * Grisage des boutons de connexion et inscription en mode invité
       */
      var connectionLink = document.getElementById("connection-a");
      var connectionBtn = document.getElementById("connection-btn");
      var registerLink = document.getElementById("register-a");
      var registerBtn = document.getElementById("register-btn");
      var fbBtn = document.getElementById("fb-btn");
      var googleBtn = document.getElementById("google-btn");
      
      connectionLink.setAttribute("class", "nav-link d-sm-flex align-items-sm-center text-red disabled");
      connectionBtn.setAttribute("class", "btn btn-outline-light btn-rounded disabled");
      registerLink.setAttribute("class", "nav-link d-sm-flex align-items-sm-center disabled");
      registerBtn.setAttribute("class", "btn btn-outline-light btn-rounded disabled");
      fbBtn.setAttribute("class", "nav-link d-sm-flex align-items-sm-center fa fa-facebook-square fa-2x text-white disabled");
      googleBtn.setAttribute("class", "nav-link d-sm-flex align-items-sm-center fa fa-google-plus-square fa-2x text-white disabled");
      
      //h1.setAttributeNode(att); 
    </script>
  <?php endif ; ?>
  <script  type="text/javascript">
  window.onbeforeunload = function() { 
      window.setTimeout(function () { 
          window.location.replace("/View/html/endGamePage.php");
      }, 0); 
      window.onbeforeunload = null; // necessary to prevent infinite loop, that kills your browser 
  }
  </script>
<body onload="startGame()">
    <div class="container-fluid container-body">
        <?php include "partials/alertsPartial.php" ?>
        <div class="row">
          <div class="col-12 d-flex justify-content-center">
            <div id="timeCount" class="p-5 d-flex align-items-center" style="margin-top: -70px;">

            </div>
          </div>
        </div>
        <div class="row">
            <div class="col-8">
                <div id="game" class="border border-secondary rounded-pill">
                    <form class="" action="" id="searchForm" name="searchForm" method="post" onsubmit='fonctionvalider();return false;'>

                        <div class="form-group text-center">
                            <label for="wordGame" id="wordGame" class="col-form-label"><h1 class="font-weight-bold"> 
                            <?php require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/TermeAleatoire.php"; ?></h1></label>
                        </div>
                        
                        <div class="form-group row justify-content-center">
                            <div class="col-6 ">
                              <input class="form-control" placeholder="Entrez un mot" id="search" name="search" required>
                            </div>
                            
                            <div class="col-1 ml-5 mt-2">
                              <select class="form-select form-select-sm border rounded" id="langue_values" name="langue_values">
                                <option selected value="<?php echo $lan ?>"><?php echo $lan ?></option>
                                <?php require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/langue.php"; ?>
                              </select>
                            </div>
                          
                            <div class="col-2 ml-5">
                              <div class="form-group">
                                <button onclick="fonctionvalider()" type="button" class="btn btn-primary form-control" id="valideBtn">Valider</button>
                              </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                          <p class="font-weight-bold text-white" id="nb-words">Il vous reste <?php echo $wordCounter;?> termes à proposer.</p>
                          <div class="form-group mt-5">
                            <!-- Affichage du bouton "Ajouter temps" si l'utilisateur est connecté -->
                            <?php if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) : ?>
                              <input type="hidden" id="credit-val" value="<?php echo $_SESSION["credit"]?>" />
                              <button type="button" class="btn btn-primary btn-sm" id="addTime" onclick="addTimeLimit()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-clock" viewBox="0 0 20 20">
                                  <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                  <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                </svg> Ajouter temps
                              </button>
                            <?php else : ?>
                              <!-- Sinon on affiche rien si l'utilisateur n'est pas connecté -->
                            <?php endif ; ?>

                            <button type="button" class="btn btn-primary btn-lg mr-5 ml-5" id="finish-btn" onclick="redirectEndGame()">Terminer la partie</button>
                            

                            <!-- Affichage du bouton "Ajouter termes" si l'utilisateur est connecté -->
                            <?php if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) : ?>
                              <button type="button" class="btn btn-primary btn-sm" id="addWords" onclick="addWordsLimit()"> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus" viewBox="0 0 20 20">
                                  <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                </svg> Ajouter termes
                              </button>
                              <?php else : ?>
                                <!-- On affiche rien si l'utilisateur n'est pas connecté -->
                              <?php endif ; ?>
                          </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-4" style="margin-top: -200px;">
              <h3 class="text-center"><i class="fas fa-h3">Vos propositions</i></h3>
                <div id="wordTab" class="table-responsive" style="max-height: 500px; overflow-y : auto;">
                    <table style="background-color:rgba(0, 0, 0, 0.3); table-layout: fixed; width: 100%;" class="table table-bordered border-white" id="tableau" name="tableau">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" style="width: 65%;"></th>
                                <th scope="col" style="width: 20%;"></th>
                                <th scope="col" style="width: 20%;"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
  </div>
  <!-- snackbar -->
  <div id="snackbarNotEnoughCredit">Vous n'avez pas assez de crédits !</div>
  <div id="snackbarSuccessCredit">Vous avez depensé 200 crédits !</div>
  <?php include "partials/backgroundAnimation.php" ?>
</body>

<footer>
</footer>
</html>