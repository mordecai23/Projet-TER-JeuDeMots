<?php
require_once "ConnectionBDD.php";
require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/User/UserController.php";

$db = DataBase::getInstance(); //établir la connexion

$queryRank = "SELECT r.score, u.userName, us.valueAttribute, r.idUser FROM ranking r, User u, UserAttributes us WHERE r.idUser = u.idUser AND u.idUser = us.idUser 
AND us.nameAttribute = 'urlAvatar' AND r.type = 2 AND r.score > 0 ORDER BY r.score DESC, u.userName ASC LIMIT 3;";

$s = DataBase::launchQuery($db, $queryRank);


  $tabUserId = array();
  $tabUsername = array();

  while ($rows = $s->fetch(PDO::FETCH_LAZY)) {
    array_push($tabUserId, $rows["idUser"]);
    array_push($tabUsername, $rows["userName"]);
  }

  $podium = "Podium mensuel : <br>";
  // TOP 3 du classement
  $i = 1;
  foreach($tabUserId as $userId) {
    $queryCredit = "SELECT valueAttribute FROM UserAttributes WHERE nameAttribute = 'credit' AND idUser = ".$userId.";";
    $s = DataBase::launchQuery($db, $queryCredit);
    $rows = $s->fetch(PDO::FETCH_LAZY);
    $credit = intval($rows["valueAttribute"]);

    $gain;
    $message = "";
    // Recompense des 3 premiers joueurs du mois
    if ($i == 1) {
      $gain = 4000;
      $message .= "Félicitation, Vous avez gagné la compétition du mois ! <br>";
    } else if ($i == 2) {
      $gain = 1500;
    } else {
      $gain = 700;
    }

    $credit = $credit + $gain;
    $message .= "Vous avez gagné ".$gain." NYT, votre rang mensuel : ".$i." .";
    updateCredit($userId, $credit);
    addUserEvent($userId, $message);

    $podium .= $tabUsername[$i-1] ." rang : ".$i." .<br>";
    $i = $i + 1;
  }

  addGlobalEvent($podium);
  
  // Reste du classement
  $queryAllUsers = "SELECT idUser FROM User where idUser !=84;";
  $s = DataBase::launchQuery($db, $queryAllUsers);

  while ($rows = $s->fetch(PDO::FETCH_LAZY)) {
    $rankUser = getUserRank($rows["idUser"], 2);
    addUserEvent($rows["idUser"], "Votre rang mensuel : ". $rankUser." .");
  }
  




$queryreset="UPDATE ranking SET score=0 WHERE type=2";
$s = $db->prepare($queryreset);
$s->execute();
?>