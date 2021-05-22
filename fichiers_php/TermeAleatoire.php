
<?php
/* ce programme permet d'obtenir un terme aléatoire dans une des langues dans laquelle le joueur joue */

require_once "ConnectionBDD.php";
$db = DataBase::getInstance(); //établir la connexion
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['loggedIn'])) {
    $username = $_SESSION['username']; //username du joueur

} else {
    $_SESSION['username'] = "totor";
    $username = "totor";
}

// Si le joueur réessaye une partie avec le même terme
if (isset($_SESSION['retrySameTerm']) && $_SESSION['retrySameTerm'] == true) {
  
  $ta=$_SESSION['termedonnee'];
  $la=$_SESSION['la'];
  $_SESSION['tableauterme'] = array();
  $_SESSION['tableaulangue'] = array();
  $_SESSION['bool']=true;
  $_SESSION['aff']="";
  $_SESSION['pointTotal']=0;
  $_SESSION['boolcredit']=true;
  $_SESSION['boolTrick']=true;
  $_SESSION['retrySameTerm'] = false;

  $lan=$la;
  
  addUserEvent($_SESSION["userId"], "Vous avez dépensé 500 NYT pour recapturer le terme : ".$ta." .");

  echo '<b class="deepshd">' . $ta . " (" . $la . ") </b>"; //affichage du terme dans le HTML


} else { // Si le joueur demarre une nouvelle partie.


  $langues = []; // les langues du joueur
  $query = "SELECT value FROM UserNode INNER JOIN Node on Node.idNode=UserNode.idNode INNER JOIN User ON User.idUser=UserNode.idUser WHERE Node.type=2 AND User.userName=" . $db->quote(trim($username));

  // éxecution requête SQL langues
  $s = $db->prepare($query);
  $s->execute();

  while ($rows = $s->fetch(PDO::FETCH_LAZY)) { // indique que la relation doit être chargée à la demande
      array_push($langues, $rows['value']);
  }

  if (!isset($_SESSION)) { session_start();
    }
  if (!isset($_SESSION['loggedIn'])) {$arrr=$_SESSION['langa'];
      if($arrr===NULL){$laaa="fr";
      }
  else{
  $laaa = $arrr[rand(0, count($arrr) - 1)];
  }
  $la=$laaa;
  }


  else{$la = $langues[rand(0, count($langues) - 1)];} //choisi une langue aléatoirement}
  $query1 = "SELECT value FROM Relation INNER JOIN Node ON Node.idNode=Relation.idNode1 WHERE idNode1 IN (SELECT idNode FROM Node WHERE Node.type=1) AND idNode2= (SELECT idNode FROM Node WHERE Node.type=2 AND Node.value=" . $db->quote($la) . ")";

  $termes = []; //contient les termes

  // éxecution requête SQL termes
  $s = $db->prepare($query1);
  $s->execute();

  while ($rows1 = $s->fetch(PDO::FETCH_LAZY)) { // indique que la relation doit être chargée à la demande
      array_push($termes, $rows1['value']);
  }

  $ta = $termes[rand(0, count($termes) - 1)]; //choisi un terme aléatoirement


  $_SESSION['termedonnee'] = $ta;
  $_SESSION['tableauterme'] = array();
  $_SESSION['tableaulangue'] = array();
  $_SESSION['la']=$la;
  $_SESSION['bool']=true;
  $_SESSION['aff']="";
  $_SESSION['pointTotal']=0;
  $_SESSION['boolcredit']=true;
  $_SESSION['boolTrick']=true;
  $_SESSION['retrySameTerm'] = false;

  $lan=$la;

  echo '<b class="deepshd">' . $ta . " (" . $la . ") </b>"; //affichage du terme dans le HTML


}


?>
