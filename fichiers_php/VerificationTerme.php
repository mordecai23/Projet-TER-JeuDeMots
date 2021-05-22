<?php
// Pour gérer les requêtes de la bdd etc
include_once $_SERVER['DOCUMENT_ROOT'].'/fichiers_php/ConnectionBDD.php'; //connexion à la bdd
if (!isset($_SESSION)) { session_start(); }
 
$db = DataBase::getInstance(); // connect to the db

$terme1=$db->quote(trim($_SESSION['search']));
$queryverif = "SELECT idNode FROM Node WHERE Node.value=" . $terme1;

 // requête SQL
    $s = $db->prepare($queryverif);
    $s->execute();
    
   while($rows = $s->fetch(PDO::FETCH_LAZY)) { // indique que la relation doit être chargée à la demande
       $idnode = $rows['idNode'];
    
    }
    $nbterme = $s->rowCount(); //Le nombre de résultats renvoyés

    echo strval($nbterme);
?>
