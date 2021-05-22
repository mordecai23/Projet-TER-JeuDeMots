<?php
require_once "ConnectionBDD.php";
require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/User/UserController.php";
$db = DataBase::getInstance(); //établir la connexion

$queryRank = "SELECT u.idUser,r.score, u.userName, us.valueAttribute FROM ranking r, User u, UserAttributes us WHERE r.idUser = u.idUser AND u.idUser = us.idUser 
AND us.nameAttribute = 'urlAvatar' AND r.type = 3 AND r.score > 0 ORDER BY r.score DESC, u.userName ASC LIMIT 3;";

$s = $db->prepare($queryRank);
$s->execute();


  $tabUserId = array();
  $tabUsername = array();

  while ($rows = $s->fetch(PDO::FETCH_LAZY)) {
    array_push($tabUserId, $rows["idUser"]);
    array_push($tabUsername, $rows["userName"]);
  }

  $podium = "Podium hebdomadaire : <br>";
  // TOP 3 du classement
  $i = 1;
  foreach($tabUserId as $userId) {
    $queryCredit = "SELECT valueAttribute FROM UserAttributes WHERE nameAttribute = 'credit' AND idUser = ".$userId.";";
     $s = $db->prepare($queryCredit);
     $s->execute();
    $rows = $s->fetch(PDO::FETCH_LAZY);
    $credit = intval($rows["valueAttribute"]);

    $gain;
    $message = "";
    // Recompense des 3 premiers joueurs du mois
    if ($i == 1) {
      $gain = 1000;
      $message .= "Félicitation, Vous avez gagné la compétition de la semaine ! <br>";

    } else if ($i == 2) {
      $gain = 500;
    } else {
      $gain = 200;
    }

    $credit = $credit + $gain;
    $message .= "Vous avez gagné ".$gain." NYT, votre rang hebdomadaire : ".$i." .";
    updateCredit($userId, $credit);
    addUserEvent($userId, $message);

    $podium .= $tabUsername[$i-1] ." rang : ".$i." .<br>";
    $i = $i + 1;
  }

  addGlobalEvent($podium);

  // Reste du classement
  $queryAllUsers = "SELECT idUser FROM User where idUser !=84;";
   $s = $db->prepare($queryAllUsers);
    $s->execute();

  while ($rows = $s->fetch(PDO::FETCH_LAZY)) {
    $rankUser = getUserRank($rows["idUser"], 3);
    addUserEvent($rows["idUser"], "Votre rang hebdomadaire : ". $rankUser." .");
  }
  


$queryreset="UPDATE ranking SET score=0 WHERE type=3";
$s = $db->prepare($queryreset);
$s->execute();
?>