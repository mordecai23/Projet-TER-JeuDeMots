<?php

if(isset($_GET["alertMessage"]) && isset($_GET["alertType"]))
{
    $alertMessage = $_GET["alertMessage"];
    $alertType = $_GET["alertType"];

    if (!empty($alertMessage) && !empty($alertType))
    {
        echo "<div class='mt-4 alert alert-$alertType alert-dismissible fade show' role='alert'>";
        echo $alertMessage;
        echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
        echo "<span aria-hidden='true'>×</span>";
        echo "</button>";
        echo "</div>";
    }
}

?>