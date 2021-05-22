<?php
  if (!isset($_SESSION)) 
  { 
    session_start(); 
  }

?>
<!DOCTYPE html>
<html lang="fr">
<?php include "partials/headerPartial.php" ?>
<body onload="loadingGame()">
    <div class="container-fluid container-body">
        <?php include "partials/alertsPartial.php" ?>
        <div class="row">
          <div class="col-2">
                
          </div>
          <div class="col-8">
            <div id="beginCountDown">
            
            </div>
          <div class="col-2">
              
          </div>
            
        </div>
      </div>
    </div>
    <?php include "partials/backgroundAnimation.php" ?>
</body>

<footer>
</footer>
</html>