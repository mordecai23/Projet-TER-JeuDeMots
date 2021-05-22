<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/fichiers_php/ConnectionBDD.php'; //connexion à la bdd
$db = DataBase::getInstance(); //établir la connexion

if (!isset($_SESSION))
{
    session_start();
}
if (isset($_SESSION['loggedIn']))
{
    $username = $_SESSION['username']; //username du joueur

}
else
{
    $_SESSION['username'] = "totor";
    $username = "totor";
}

if ($_SESSION['bool'] == true)
{

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    $termeD = $db->quote(trim($_SESSION['termedonnee'])); //Le terme aléatoire proposé pour jouer
    $queryd = "SELECT idNode FROM Node WHERE value=" . $termeD;
    $s = $db->prepare($queryd);
    $s->execute();
    $termeDonne;
    while ($rows = $s->fetch(PDO::FETCH_LAZY))
    {
        // indique que la relation doit être chargée à la demande
        $termeDonne = $rows['idNode'];
    }
    $pointTotal = 0;
    $_SESSION['iddonne']=$termeDonne;
    $tableauterme = $_SESSION['tableauterme'];
    $tableaulangue = $_SESSION['tableaulangue'];
    $taille = count($tableauterme);
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    foreach ($tableaulangue as $valueterme => $langval)
    {
        $termesaisie = $db->quote(trim($valueterme)); //Le terme saisie
        $languetermesaisie = $db->quote(trim($langval)); //La langue du terme saisie
        $query = "SELECT idNode FROM Node WHERE value=" . $termesaisie; // requete pour connaitre le idnode du terme saisi
        // éxecution requête SQL pour rechercher le terme saisi
        $s = $db->prepare($query);
        $s->execute();

        while ($rows = $s->fetch(PDO::FETCH_LAZY))
        {
            // indique que la relation doit être chargée à la demande
            $idterme = $rows['idNode'];
        }
        $nbtuple = $s->rowCount(); //Le nombre de résultats renvoyés
        //echo $idterme;
        $querylangue = "SELECT idNode FROM Node WHERE value=" . $languetermesaisie; //connaitre le idnode de la langue du terme
        $s = $db->prepare($querylangue);
        $s->execute();
        $tupleL = $s->fetch(PDO::FETCH_LAZY);
        $idlangue = $tupleL['idNode'];

        $nbpoint = 10; //le nombre de points pour ce terme
        $creationDate = $db->quote(date('Y-m-d H:i:s')); //la date actuelle et l'heure
        if (!($nbtuple == 1))
        {
            //si aucun tuple trouvé(le terme éxiste pas)


            $queryinsertion = "INSERT INTO Node (type,value) VALUES (3," . $termesaisie . ")"; //insertion du terme dans la table Node
            //echo $queryinsertion;
            $s = $db->prepare($queryinsertion);
            $s->execute();
            //echo "Nouveau terme inséré";
            $queryidNode = "SELECT idNode FROM Node WHERE value=" . $termesaisie; //le idnode du nouveau terme rentré
            $s = $db->prepare($queryidNode);
            $s->execute();
            $tuple = $s->fetch(PDO::FETCH_LAZY);
            $idNode2 = $tuple['idNode'];

            //requete pour insérer la nouvelle relation et sa langue
            $queryinsertionrelation = "INSERT INTO Relation (creationDate,idNode1,idNode2,lastTimeTouched,type,weight) VALUES 
(" . $creationDate . "," . $idNode2 . "," . $idlangue . "," . $creationDate . "," . "2,0)," . " (" . $creationDate . "," . $termeDonne . "," . $idNode2 . "," . $creationDate . "," . "1,10)";

            $s = $db->prepare($queryinsertionrelation);
            $s->execute();
            if (isset($_SESSION['loggedIn']))
            {
                $queryuserrealtion = "INSERT INTO UserRealtion(annuity,idUser,idRelation) SELECT 200," . $_SESSION["userId"] . ",idRelation FROM Relation where idNode1=" . $termeDonne . " and idNode2=" . $idNode2;
                $s = $db->prepare($queryuserrealtion);
                $s->execute();
            }

        }
        else
        {
            $queryidNode = "SELECT idNode FROM Node WHERE value=" . $termesaisie; //le idnode du nouveau terme rentré
            $s = $db->prepare($queryidNode);
            $s->execute();
            $tuple = $s->fetch(PDO::FETCH_LAZY);
            $idNode2 = $tuple['idNode'];
            //echo "Le terme éxiste";
            //si la relation éxiste
            $queryVr = "SELECT idRelation,weight FROM Relation WHERE idNode1=" . $termeDonne . " AND idNode2=" . $idterme;
            $s = $db->prepare($queryVr);
            $s->execute();
            $tupleR = $s->fetch(PDO::FETCH_LAZY);

            if ($s->rowCount() > 0)
            {
                $idRelation = $tupleR['idRelation'];
                $weight = (int)$tupleR['weight'];
            }

            if ($s->rowCount() < 1)
            {
                //si elle n'éxiste pas
                $queryinsertionrelation = "INSERT INTO Relation (creationDate,idNode1,idNode2,lastTimeTouched,type,weight) VALUES 
        (" . $creationDate . "," . $termeDonne . "," . $idterme . "," . $creationDate . "," . "1,10)";

                $s = $db->prepare($queryinsertionrelation);
                $s->execute();
                if (isset($_SESSION['loggedIn']))
                {
                    $queryuserrealtion = "INSERT INTO UserRealtion(annuity,idUser,idRelation) SELECT 200," . $_SESSION["userId"] . ",idRelation FROM Relation where idNode1=" . $termeDonne . " and idNode2=" . $idNode2;
                    $s = $db->prepare($queryuserrealtion);
                    $s->execute();
                }
            }
            //si elle éxiste
            else
            {
                if (isset($_SESSION['loggedIn']))
                {
                    $queryverif = "select idUser from UserRealtion where idRelation=(SELECT idRelation FROM Relation where idNode1=" . $termeDonne . " and idNode2=" . $idNode2 . ") and annuity>0 and idUser !=".$_SESSION["userId"];
                    $s = $db->prepare($queryverif);
                    $s->execute();
                    $tupleverif = $s->fetch(PDO::FETCH_LAZY);

                    if ($s->rowCount() > 0)

                    {
                        $queryannuity = "UPDATE UserRealtion SET annuity=annuity-20 where annuity>0 and idRelation=" . "(SELECT idRelation FROM Relation where idNode1=" . $termeDonne . " and idNode2=" . $idNode2 . ");";
                        $s = $db->prepare($queryannuity);
                        $s->execute();

                        $querypoint = "select valueAttribute FROM UserAttributes WHERE idUser=(SELECT idUser FROM UserRealtion WHERE idRelation=(SELECT idRelation FROM Relation where idNode1=" . $termeDonne . " and idNode2=" . $idNode2 . ")) AND nameAttribute='credit'";
                        $s = $db->prepare($querypoint);
                        $s->execute();
                        $tuple = $s->fetch(PDO::FETCH_LAZY);
                        $credit = (int)$tuple['valueAttribute'];
                        $credit = $credit + 20;

                        $queryupdateuserpoint = "UPDATE UserAttributes set valueAttribute='" . $credit . "' where nameAttribute='credit' AND idUser=(SELECT idUser FROM UserRealtion WHERE idRelation=(SELECT idRelation FROM Relation where idNode1=" . $termeDonne . " and idNode2=" . $idNode2 . "))";
                        $s = $db->prepare($queryupdateuserpoint);
                        $s->execute();

                        $queryOwnerRelation = "SELECT idUser FROM UserRealtion WHERE idRelation = (SELECT idRelation FROM Relation where idNode1=" . $termeDonne . " and idNode2=" . $idNode2 . ");";
                        $s = $db->prepare($queryOwnerRelation);
                        $s->execute();

                        $rows = $s->fetch(PDO::FETCH_LAZY);
                        addUserEvent($rows["idUser"], "Votre relation : ".$_SESSION['termedonnee']." - ".$termesaisie." vous a fait gagner 20 crédits.");
                    }
                }

                $nbpoint = $weight;
                //système de courbe en cloche
                if ($weight == 13)
                {
                    //poids final, n'augmente pas, diminue pas
                    $queryupdate = "UPDATE Relation SET lastTimeTouched =" . $creationDate . " WHERE idRelation=" . $idRelation;
                }
                elseif ($weight % 10 == 0 and $weight != 220)
                {
                    //on augmente le poids jusqu'à 110
                    $weight = $weight + 10;
                    $queryupdate = "UPDATE Relation SET lastTimeTouched =" . $creationDate . ", weight=" . $weight . " WHERE idRelation=" . $idRelation;
                }
                //on diminue jusqu'à 13
                else
                {
                    $weight = $weight - 23;
                    $queryupdate = "UPDATE Relation SET lastTimeTouched =" . $creationDate . ", weight=" . $weight . " WHERE idRelation=" . $idRelation;
                }
                $s = $db->prepare($queryupdate);
                $s->execute();
            }
        }
        $pointTotal = $pointTotal + $nbpoint;

        $aff = '<tr> <td class="text-center font-weight-normal text-white">' . $valueterme . '</td>
    <td class="text-center font-weight-normal text-white">' . $langval . '</td>
    <td class="text-center font-weight-normal text-white">' . $nbpoint . '</td>
  </tr>';
        $_SESSION['aff'] .= $aff;
        $_SESSION['pointTotal'] += $nbpoint;
    }
    if (isset($_SESSION['loggedIn']))
    {
        if($pointTotal==0 && $_SESSION["credit"]>=10)
        {
            $_SESSION["credit"]=$_SESSION["credit"]-10;
        }
    }
}
else
{
    if ($_SESSION['bool'] == false)
    {
        $pointTotal = $_SESSION['pointTotal'];
        //echo $_SESSION['aff'];

    }
}

?>
