<?php
   include_once $_SERVER['DOCUMENT_ROOT'] . '/fichiers_php/ConnectionBDD.php';
   require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/User/UserController.php";
   $db = DataBase::getInstance(); 
   $res=array();

   $queryAllUsers = "SELECT n1.value as Node1, n2.value as Node2, weight FROM Relation r INNER JOIN Node n1 ON n1.idNode=r.idNode1 INNER JOIN Node n2 ON n2.idNode=r.idNode2 ORDER BY Node1 ASC";
   $s = DataBase::launchQuery($db, $queryAllUsers);
   while ($rows = $s->fetch(PDO::FETCH_LAZY)) {
 
     array_push($res,array("Node1"=>$rows["Node1"],"Node2"=>$rows["Node2"],"Weight"=>$rows["weight"]));
   }

   function array_to_csv_download($array, $filename = "Relations.csv", $delimiter=",") {
    
    $f = fopen('php://memory', 'w'); 
    
    foreach ($array as $line) { 
       
        fputcsv($f, $line, $delimiter); 
    }

    fseek($f, 0);
    
    header('Content-Type: application/csv');
    
    header('Content-Disposition: attachment; filename="'.$filename.'";');
    
    fpassthru($f);
}

array_to_csv_download($res);
?>