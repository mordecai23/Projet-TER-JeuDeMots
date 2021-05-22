<?php
require_once $_SERVER['DOCUMENT_ROOT']. '/libs/GoogleLogin/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/User/UserController.php";

// Gestion du  démarrage de la session
if (!isset($_SESSION))
{
    session_start();
}

// init configuration
$clientID = '816824692649-v1lckc4qlen7pnbshp4h65ddem1ot1hg.apps.googleusercontent.com';
$clientSecret = '9JG8If_z4SxxOCOdW0EEykSl';
$redirectUri = 'https://' . $_SERVER["HTTP_HOST"] . '/View/html/redirect.php';


// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // get profile info
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $email =  $google_account_info->email;
    $name =  $google_account_info->name;

    if (!isExistingEmailAddress($email, null)) {
        // Cas où l'adresse mail n'existe pas dans la base.
        register("/View/images/avatar1.jpg", $name, $email, "NONE", "NONE", array("fr"));
    } else {
        // Cas où l'adresse existe dans la base.
        login($name, "NONE");
    }

    // Cas où l'adresse existe mais où elle est liée à un compte "normal".
    if (!isset($_SESSION['userId'])) {
        $message = "Cette adresse mail est déjà utilisée.";
        header("Location: /homePage.php?alertMessage=$message&alertType=danger");
    }
}

header("Location: /homePage.php");