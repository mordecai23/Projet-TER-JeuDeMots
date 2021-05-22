<?php
require_once $_SERVER['DOCUMENT_ROOT']. '/libs/GoogleLogin/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/User/UserController.php";
require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/User/UserQueries.php";

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
        addUser($name, $email, "NONE");
        addUserAvatar($email, "/View/images/avatar1.jpg");
        addUserLanguages($email, array("fr"));
        addCreditUser($email);
        addLevelUser($email);
        addRankPointUser($email);
    }

    $_SESSION["loggedIn"] = true;
    $_SESSION['avatarSrc'] = "/View/images/avatar1.jpg";
    $_SESSION["username"] = $name;
    $_SESSION['userId'] = getUserIdByUserName($name);
    $_SESSION['credit'] = getUserCredit();
    $_SESSION['level'] = getUserLevel($_SESSION['userId']);
    
    // now you can use this profile info to create account in your website and make user logged in.
} else {
    echo "<a class='nav-link d-sm-flex align-items-sm-center fa fa-google-plus-square fa-2x text-white' id='google-btn' href='".$client->createAuthUrl()."'></a>";
}
