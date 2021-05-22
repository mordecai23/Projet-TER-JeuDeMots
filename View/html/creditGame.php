<?php

if (!isset($_SESSION)) {
    session_start();
}
$var=$_POST["valueCredit"];

$_SESSION["credit"] = $_SESSION["credit"]-200;



?>