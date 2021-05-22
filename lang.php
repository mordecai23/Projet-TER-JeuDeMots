<?php 
if (!isset($_SESSION)) {
    session_start();
}
$_SESSION['langa']=$_POST['langa'];
print_r($_POST['langa']);
print_r($_SESSION['langa']);
?>