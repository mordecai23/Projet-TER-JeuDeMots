<?php
if (!isset($_SESSION)) {
  session_start();
}

echo strval($_SESSION["credit"]);
?>