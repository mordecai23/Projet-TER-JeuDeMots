<?php

require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/User/UserController.php";

if (!isset($_SESSION)) {
    session_start();
}

logout();
?>