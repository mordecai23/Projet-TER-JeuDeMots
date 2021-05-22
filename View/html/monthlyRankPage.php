<?php
  if (!isset($_SESSION)) { session_start(); }
?>
<!DOCTYPE html>
<html lang="fr">
<?php include "partials/headerPartial.php" ?>
<body onload="timerMonth()">

  <div class="container-fluid container-body">
    <?php include $_SERVER['DOCUMENT_ROOT']."/View/html/partials/alertsPartial.php" ?>
    <div class="row mt-5 mb-3">
      <div class="col-3 text-center">
        <h4 class="text-center mb-5"><i class="fas fa-h4"><strong>Récompenses mensuelles</strong></i></h4>
        <p><img src="/View/images/firstPlace_medal.png"/><strong> 4000 NYT </strong></p>
        <p><img src="/View/images/secondPlace_medal.png"/><strong> 1500 NYT </strong></p>
        <p><img src="/View/images/thirdPlace_medal.png"/><strong>700 NYT </strong></p>
      </div>
      <div class="col-6 text-center">
        <h1 class="h1 mb-5">Classement mensuel</h1>
        <?php include $_SERVER['DOCUMENT_ROOT']."/fichiers_php/Ranking.php"; Monthlyranking(); ?>
      </div>
      <div class="col-3 text-center">
        <h4 class="text-center"><i class="fas fa-h4"><strong>Temps restant</strong></i></h4>
        <div id="countdown-month">
          <ul>
            <li><span id="days-month"></span>Jours</li>
            <li><span id="hours-month"></span>Heures</li>
            <li><span id="minutes-month"></span>Minutes</li>
            <li><span id="seconds-month"></span>Secondes</li>
          </ul>
        </div>
        
      </div>
    </div>

  <?php include "partials/backgroundAnimation.php" ?>
</body>
<footer>
</footer>
</html>

