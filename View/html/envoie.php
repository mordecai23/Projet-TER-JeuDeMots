<?php
if (!isset($_SESSION)) {
    session_start();
}

$_SESSION['search'] = $_POST['search'];
$lang= $_POST['lang'];

if(strcmp($lang,"default")==0){$lang=$_SESSION['la'];}

array_push($_SESSION['tableauterme'], $_POST['search']); //mettre les termes dans un tableau de variable session
print_r($_SESSION['tableauterme']);
$tabl=$_SESSION['tableaulangue'];
$tabl[$_POST['search']]=$lang;
$_SESSION['tableaulangue']=$tabl;

//print_r ($tabl);

?>