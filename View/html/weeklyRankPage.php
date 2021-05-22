<?php
  if (!isset($_SESSION)) { session_start(); }
?>
<!DOCTYPE html>
<html lang="fr">
<?php include "partials/headerPartial.php" ?>
<body onload="timerWeek()">

  <div class="container-fluid container-body">
    <?php include $_SERVER['DOCUMENT_ROOT']."/View/html/partials/alertsPartial.php" ?>
    <div class="row mt-5 mb-3">
      <div class="col-3 text-center">
        <h4 class="text-center mb-5"><i class="fas fa-h4"><strong>Récompenses hebdomadaires</strong></i></h4>
        <p><img src="/View/images/firstPlace_medal.png"/><strong> 1000 NYT </strong></p>
        <p><img src="/View/images/secondPlace_medal.png"/><strong>500 NYT </strong></p>
        <p><img src="/View/images/thirdPlace_medal.png"/><strong>200 NYT </strong></p>
      </div>
      <div class="col-6 text-center">
        <h1 class="h1 mb-5">Classement hebdomadaire</h1>
        <?php include $_SERVER['DOCUMENT_ROOT']."/fichiers_php/Ranking.php"; weeklyranking(); ?>
      </div>
      <div class="col-3 text-center">
        <h4 class="text-center"><i class="fas fa-h4"><strong>Temps restant</strong></i></h4>
        <div id="countdown-week">
          <ul>
            <li><span id="days-week"></span>Jours</li>
            <li><span id="hours-week"></span>Heures</li>
            <li><span id="minutes-week"></span>Minutes</li>
            <li><span id="seconds-week"></span>Secondes</li>
          </ul>
        </div>
      </div>
    </div>
    
  <?php include "partials/backgroundAnimation.php" ?>
</body>
<footer>
</footer>
</html>

