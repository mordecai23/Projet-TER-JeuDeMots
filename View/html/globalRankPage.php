<?php
  if (!isset($_SESSION)) { session_start(); }
?>
<!DOCTYPE html>
<html lang="fr">
<?php include "partials/headerPartial.php" ?>
<body>

  <div class="container-fluid container-body">
    <?php include $_SERVER['DOCUMENT_ROOT']."/View/html/partials/alertsPartial.php" ?>
    <div class="row mt-5 mb-3">
      <div class="col-2"></div>
      <div class="col-8 text-center">
        <h1 class="h1">Classement général</h1>
      </div>
      <div class="col-2"></div>
    </div>
    <div class="row">
      <div class="col-3">
        
      </div>
      <div class="col-6 text-center mt-5">
         <?php include $_SERVER['DOCUMENT_ROOT']."/fichiers_php/Ranking.php"; globalranking(); ?>

      </div>
      <div class="col-3">

      </div>
    </div>
    
  <?php include "partials/backgroundAnimation.php" ?>
</body>
<footer>
</footer>
</html>

