<?php

require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/User/UserController.php";

$code = $_GET["code"];
$userId = $_GET["userId"];

emailConfirmation($userId, $code);