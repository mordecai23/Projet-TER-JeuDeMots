<?php

require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/User/UserController.php";

if (!isset($_SESSION))
{
    session_start();
}

// Booleen permettant de savoir si le joueur a relancé une partie avec le même terme.
$_SESSION["retrySameTerm"] = false;

if (isSubmitted()) {
    // 1000 NYT dépensé par le joueur pour réessayer une partie avec le même terme.
    $_SESSION["credit"] = $_SESSION["credit"] - intval($_POST["retryPrice"]);

    $_SESSION["retrySameTerm"] = true;

    // Mise à jour du crédit
    updateCredit($_SESSION["userId"], $_SESSION["credit"]);

    header("Location: /View/html/loadingPage.php");
}

require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/SaisieTerme.php";
$capture = require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/captureTerme.php";


?>
<!DOCTYPE html>
<html lang="fr">
<?php include "partials/headerPartial.php" ?>

<body>
<div class="container-fluid container-body" id="main-body">
    <?php include "partials/alertsPartial.php" ?>
    <div class="row justify-content-center">
        <div class="col-3">
            <div class="d-grid gap-2 col-12 mx-auto pt-5">
                <button id="retry-btn"class="btn btn-success btn-lg btn-block" type="button" onclick="redirectLoadingPage1()"><i class="fa fa-repeat mr-3" aria-hidden="true"></i>Nouvelle partie</button>
            </div>
        </div>
        <div class="col-6 text-center">
            <div id="final-score-div">

                <label class="col-form-label mt-5 text-center"><h1 class="retroshd"> <?php echo $_SESSION['termedonnee']. " : ". $pointTotal ." points."   ?> </h1></label>  </br>
                <?php if(isset($_SESSION['loggedIn'])) : ?>
                    <label class="col-form-label mt-3 text-center"><h3 class="retroshd mb-3"><?php require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/updateCredit.php"; echo $_SESSION['creditwon'] ." NYT gagnés." ?></h3></label>
                <?php endif; ?>
                <p id="capture" name="capture" style="border:1px; border-style:solid; border-color:black; padding: 1em;">
                    <?php echo $capture; ?>
                </p>

                <?php if($pointTotal!=0) : ?>
                    <div id="end-word-table" style="max-height: 500px; overflow-y : auto;">
                        <table class="table border" id="table-end" name="table-end" style="background-color:rgba(0, 0, 0, 0.3);">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col"><p class="font-weight-bold text-center">Terme</p></th>
                                <th scope="col"><p class="font-weight-bold text-center">Langue</p></th>
                                <th scope="col"><p class="font-weight-bold text-center">Points</p></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php echo $_SESSION['aff']; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <div class="col-3 ">
            <?php
            //Affichage d'une astuce lorsque le score final >= 30
            if ($pointTotal >= 30) {
                require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/Tricks.php";
            }
            ?>

            <div class="d-grid gap-2 col-12 mx-auto pt-5">

                <?php if(isset($_SESSION['loggedIn']) && $_SESSION['capture']==false) : ?>
                    <?php require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/retry.php"; ?>
                <?php endif; ?>
                <?php if(isset($_SESSION['loggedIn']) && $_SESSION["credit"]>=500 &&  $_SESSION['capture']==false) : ?>
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <input type="hidden" name="retryPrice" value="500">
                        <button id="retrycapture" class="btn btn-info btn-lg btn-block" type="submit"><i class="fa fa-repeat mr-3" aria-hidden="true"></i>Réessayer (500 NYT)</button>
                    </form>
                <?php endif; ?>
            </div>


        </div>

        <div class="col-3 ">


        </div>

    </div>

</div>
<?php include "partials/backgroundAnimation.php" ?>
</body>

<footer>
</footer>
</html>