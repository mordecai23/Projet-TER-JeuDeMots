
<?php
require_once "ConnectionBDD.php";
$db = DataBase::getInstance(); //établir la connexion

$query="UPDATE Node set type=1 where idNode in 
(SELECT idNode2 FROM Relation where weight > 50)
OR idNode IN
(SELECT idNode2 FROM Relation WHERE type=1 GROUP BY idNode2 HAVING COUNT(*) >=5)";
$s = $db->prepare($query);
$s->execute();

?>