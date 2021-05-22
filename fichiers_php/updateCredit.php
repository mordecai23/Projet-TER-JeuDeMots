<?php

require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/User/UserController.php";

$creditWon = 0;

// Calcul du nouveau crédit
if (isset($_SESSION['loggedIn']) && $_SESSION['boolcredit']==true) {

    $_SESSION["score"] = getUserScore() + $pointTotal;

    $queryUpdate = "UPDATE ranking SET score = score +'".$pointTotal."' WHERE idUser = ".$_SESSION["userId"].";";
    $s = $db->prepare($queryUpdate);
    $s->execute();

    // Le joueur gagne des extra credits en fonction de son niveau
    $extraCreditLevel = $_SESSION["level"] * 10;
    
    if ($pointTotal <= 0) {
      $extraCreditLevel = 0;
    }
    

    // Le joueur gagne 10 % de plus de crédits si il capture un terme
    $extraCreditCapture = intdiv($pointTotal, 10);
    
    $creditWon = $pointTotal + $extraCreditLevel;

    if($_SESSION["capture"] == true ){
      $creditWon += $extraCreditCapture;
    }
    $_SESSION['creditwon']=$creditWon;
    $newCredit = $_SESSION["credit"] + $creditWon;
    
    $_SESSION["credit"]=$newCredit;

    $query = "UPDATE UserAttributes SET valueAttribute = '" . $newCredit . "' WHERE nameAttribute = 'credit' AND idUser = ".$_SESSION["userId"].";" ;
    $s = $db->prepare($query);
    $s->execute();
    $_SESSION['boolcredit']=false;

    handleLevel($_SESSION["userId"]);
}

?>