<?php
  if (!isset($_SESSION)) { session_start(); }
?>
<!DOCTYPE html>
<html lang="fr">
    <?php include "partials/headerPartial.php" ?>
    <body>
        <div class="container container-body">
            <?php include "partials/alertsPartial.php" ?>
        </div>

        <div class="text-center">
            <p class="">Ce jeu a été fait par des étudiants en Master Informatique AIGLE de la faculté des sciences de Montpellier.</p>

            <p class="">Le site étant toujours en développement, nous vous sommes très reconnaissant de nous faire un retour, que ce soit pour nous rapporter un bug, nous faire part d'une amélioration, ou encore pour nous conseiller sur un ajout à faire.</p>

            <a class="btn btn-info" href="mailto:wordz.system@gmail.com">Contactez-nous!</a>
            <br>
            <br>
            <p class="">Vous pouvez télécharger les données des relations en appuyant sur le bouton ci-dessous.</p>
            <br>
            <form action = "downloadcsv.php" method = "post">     
              <input class="btn btn-info" type = "submit" name = "Télécharger données" value = "Télécharger données"> 
          </form> 
        </div>
<!-- form tag to create form --> 
            
        <?php include "partials/backgroundAnimation.php" ?>
    </body>
    <footer>
    </footer>
</html>
