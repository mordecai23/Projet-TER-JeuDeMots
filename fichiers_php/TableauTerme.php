<?php
require_once "ConnectionBDD.php";
$db = DataBase::getInstance(); //établir la connexion
if (!isset($_SESSION)) {
    session_start();
}


if (isset($_SESSION['loggedIn'])) {
$username = $_SESSION['username']; //username du joueur
$tableauts=[];

$queryts="SELECT value,score FROM UserNode INNER JOIN Node on Node.idNode=UserNode.idNode INNER JOIN User ON User.idUser=UserNode.idUser WHERE score IS NOT NULL AND User.userName=" . $db->quote(trim($username))."order by value asc";

$s = $db->prepare($queryts);
$s->execute();

while ($rows = $s->fetch(PDO::FETCH_LAZY)) { // indique que la relation doit être chargée à la demande
    $tableauts[$rows['value']]=(int)$rows['score'];
}
if($s->rowCount() > 0)
{
  foreach($tableauts as $value => $score)
  {
      echo '<li class="list-group-item"><span class ="float-left"><i class="fa fa-circle"></i></span><strong class="ml-5 float-left">'.$value.'</strong> <strong class="float-right">'.$score. ' points</strong></li>';
  }
}
else
{
     echo '<li class="list-group-item"><span class ="float-left"><i class="fa fa-circle"></i></span><strong class="ml-5 float-left">Aucun terme</strong> <strong class="float-right"></strong></li>';
}

}

?>