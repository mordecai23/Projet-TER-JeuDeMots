<?php
// Pour gérer les requêtes de la bdd etc
include_once $_SERVER['DOCUMENT_ROOT'] . '/fichiers_php/ConnectionBDD.php'; //connexion à la bdd


$db = DataBase::getInstance(); // connect to the db
$username = $_SESSION['username']; //username du joueur
$querylangue = "SELECT value FROM UserNode INNER JOIN Node on Node.idNode=UserNode.idNode INNER JOIN User ON User.idUser=UserNode.idUser WHERE Node.type=2 AND User.userName=" . $db->quote(trim($username));


// requête SQL
$s = $db->prepare($querylangue);
$s->execute();

if (isset($_SESSION['loggedIn'])) {

  while ($rows = $s->fetch(PDO::FETCH_LAZY)) { // indique que la relation doit être chargée à la demande
      $lang = $rows['value'];
      $langueaffiche = "<option value='$lang'>";
  
      $langueaffiche = $langueaffiche . $lang;

      $langueaffiche = $langueaffiche . "</option>";
      if (strcmp($lang, $la) != 0) {
          echo $langueaffiche;
      }
  }
} else {

  foreach($_SESSION['langa'] as $lang) {
    
    $langueaffiche = "<option value='$lang'>";
    $langueaffiche = $langueaffiche . $lang;
    $langueaffiche = $langueaffiche . "</option>";
    if (strcmp($lang, $la) != 0) {
        echo $langueaffiche;
    }

  }
    

}