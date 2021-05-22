<?php
require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/User/UserQueries.php";

$iduser;
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['loggedIn'])) {

    if ($_SESSION['bool'] == true) {


        $username  = $_SESSION['username']; //username du joueur
        $usernameD = $db->quote(trim($_SESSION['username'])); //Le terme aléatoire proposé pour jouer
        $queryuser = "select idUser from User where userName=" . $usernameD;
        $s         = $db->prepare($queryuser);
        $s->execute();
        $rows   = $s->fetch(PDO::FETCH_LAZY); // indique que la relation doit être chargée à la demande
        $iduser = $rows['idUser'];

        /////////////////////////////////////////////////////////////////////////////////////////////////////////
        $termeD = $db->quote(trim($_SESSION['termedonnee'])); //Le terme aléatoire proposé pour jouer
        $queryd = "SELECT idNode FROM Node WHERE value=" . $termeD;
        $s      = $db->prepare($queryd);
        $s->execute();
        $idterme;
        while ($rows = $s->fetch(PDO::FETCH_LAZY)) { // indique que la relation doit être chargée à la demande
            $idterme = $rows['idNode'];
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////
        $capture      = false;
        $querycapture = "SELECT idNodeUser,score,idUser FROM UserNode WHERE idNode=" . $idterme ;
        $s            = $db->prepare($querycapture);
        $s->execute();
        $idnodeuser;
        $score=0;
        while ($rows = $s->fetch(PDO::FETCH_LAZY)) { // indique que la relation doit être chargée à la demande
            $idnodeuser = $rows['idNodeUser'];
            $score      = (int) $rows['score'];
            $userIdd=(int)$rows['idUser'];
        }
        $nbtuple = $s->rowCount();

        if ($nbtuple == 0 and $pointTotal != 0) {
            //insertion dans la BDD
            $queryinsert = "INSERT INTO UserNode(idNode,idUser,score) VALUES (" . $idterme . "," . $iduser . "," . $pointTotal . ")";
            $s           = $db->prepare($queryinsert);
            $s->execute();
            $capture = true;
        }

        if ($nbtuple == 1 and $pointTotal != 0) {
            //vérification,supression,insertion
            if ($pointTotal >= $score) {
                $queryvsi = "DELETE FROM UserNode WHERE idNodeUser=" . $idnodeuser . "; INSERT INTO UserNode(idNode,idUser,score) VALUES (" . $idterme . "," . $iduser . "," . $pointTotal . ");";
                $s        = $db->prepare($queryvsi);
                $s->execute();
                $capture = true;
                addUserEvent($userIdd, "Vous avez perdu le terme : ".$_SESSION['termedonnee']);
            }
        }

        $_SESSION['capture']=$capture;
        $_SESSION['score']=$score;

    }

    
    if ($_SESSION['capture'] == true) {

        $message = 'Félicitation vous avez capturé le terme "' . $_SESSION['termedonnee'] . '" avec le score de ' . $_SESSION['pointTotal'] . " points.";
        if ($_SESSION["bool"] == true) {
          addUserEvent($_SESSION["userId"], $message);
          addGlobalEvent($_SESSION["username"] ." a capturé le terme " . $_SESSION['termedonnee'] . " avec le score de " . $_SESSION['pointTotal'] . " points.");
          $_SESSION["bool"] = false;
        }
        
        return $message;

    } else {

        if ($_SESSION['pointTotal'] == 0) {
            $_SESSION["bool"] = false;
            return "Vous avez entré aucun terme, vous perdez 10 NYT. ";
        }

        else {
            $_SESSION["bool"] = false;
            return "Dommage, il vous manque " . ($_SESSION['score'] - $_SESSION['pointTotal']) . " points pour battre le score de ce terme.";

        }
    }


}
else {
    $_SESSION["bool"]=false;

    return "Connectez vous pour essayer de capturer ce terme !";
}



?>