<?php
if (!isset($_SESSION)) {
    session_start();
}

$_SESSION['search'] = $_POST['search'];
$lang= $_POST['lang'];

$tabl=$_SESSION['tableaulangue'];
$tabl[$_POST['search']]=$lang;
$_SESSION['tableaulangue']=$tabl;

//print_r ($tabl);

?>