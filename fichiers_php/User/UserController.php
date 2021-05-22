<?php

require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/User/UserQueries.php";
require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/FileHelper.php";
require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/EmailHelper.php";

/**
 * Permet de savoir si le formulaire de connexion a été validé.
 * @return bool Vrai si le formulaire a été validé, Faux sinon.
 */
function isSubmitted(): bool
{
    return $_SERVER["REQUEST_METHOD"] == "POST";
}

/**
 * Crée une alerte de succès.
 * @param string $message Le message.
 * @return string Les valeurs de route.
 */
function createSuccessAlert(string $message): string
{
    return "?alertMessage=$message&alertType=success";
}

/**
 * Crée une alerte d'echec.
 * @param string $message Le message.
 * @return string Les valeurs de route.
 */
function createFailureAlert(string $message): string
{
    $_GET["alertMessage"] = $message;
    $_GET["alertType"] = "danger";

    return "?alertMessage=$message&alertType=danger";
}

/**
 * Permet de savoir si le nom d'utilisateur est valide.
 * @param string $username Le nom d'utilisateur.
 * @param int|null $userId L'identifiant d'un utilisateur.
 * @return bool Vrai si le nom d'utilisateur est valide, Faux sinon.
 */
function isValidUsername(string $username, int $userId = null): bool
{
    if (empty($username))
    {
        $_GET["usernameError"] = "Le nom d'utilisateur est requis.";
        return false;

    }
    else if (isExistingUsername($username, $userId))
    {
        $_GET["usernameError"] = "Ce nom d'utilisateur déjà utilisé.";
        return false;
    }

    return true;
}

/**
 * Permet de savoir si l'adresse mail est valide.
 * @param string $emailAddress L'adresse mail.
 * @param int|null $userId L'identifiant d'un utilisateur.
 * @return bool Vrai si l'adresse mail est valide, Faux sinon.
 */
function isValidEmailAddress(string $emailAddress, int $userId = null): bool
{
    if (empty($emailAddress))
    {
        $_GET["emailError"] = "L'adresse mail est requise.";
        return false;

    }
    else if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL))
    {
        $_GET["emailError"] = "Cette adresse mail n'est pas valide.";
        return false;

    }
    else if (isExistingEmailAddress($emailAddress, $userId))
    {
        $_GET["emailError"] = "Cette adresse mail est déjà utilisée.";
        return false;
    }

    return true;
}

/**
 * Permet de savoir si le mot de passe est valide.
 * @param string $password Le mot de passe.
 * @return bool Vrai si le mot de passe est valide, Faux sinon.
 */
function isValidPassword(string $password): bool
{
    if (empty($password))
    {
        $_GET["passwordError"] = "Le mot de passe est requis.";
        return false;
    }

    return true;
}

/**
 * Permet de savoir si le mot de passe actuel est valide.
 * @param string $password Le mot de passe actuel.
 * @param int $userId L'identifiant d'un utilisateur.
 * @return bool Vrai si le mot de passe actuel est valide, Faux sinon.
 */
function isValidActualPassword(string $password, int $userId): bool
{
    if (empty($password))
    {
        $_GET["actualPasswordError"] = "Le mot de passe est requis.";
        return false;
    }

    if (!password_verify($password, getSavedPasswordById($userId)))
    {
        $_GET["actualPasswordError"] = "Le mot de passe ne correspond pas au mot de passe enregistré.";
        return false;
    }

    return true;
}

/**
 * Permet de savoir si le nouveau mot de passe est valide.
 * @param string $password Le nouveau mot de passe.
 * @return bool Vrai si le nouveau mot de passe est valide, Faux sinon.
 */
function isValidNewPassword(string $password): bool
{
    if (empty($password))
    {
        $_GET["newPasswordError"] = "Le mot de passe est requis.";
        return false;
    }

    return true;
}

/**
 * Permet de savoir si la confirmation de mot de passe est valide.
 * @param string $password La confirmation de mot de passe.
 * @param string $passwordConfirmation La confirmation de mot de passe.
 * @return bool Vrai si la confirmation de mot de passe est valide, Faux sinon.
 */
function isValidPasswordConfirmation(string $password, string $passwordConfirmation): bool
{
    if ($password != $passwordConfirmation)
    {
        $_GET["passwordConfirmationError"] = "Les mots de passe ne sont pas identiques.";
        return false;
    }

    return true;
}

/**
 * Permet de savoir si les langues sont valides.
 * @param array $languages Les langues.
 * @return bool Vrai si les langues sont valides, Faux sinon.
 */
function isValidLanguages(array $languages): bool
{
    if (empty($languages))
    {
        $_GET["languagesError"] = "Au moins un langage doit être sélectionné.";
        return false;
    }

    return true;
}

/**
 * Lance la connexion.
 * @param string $username Le nom d'utilisateur.
 * @param string $password Le mot de passe.
 */
function login(string $username, string $password): void
{
    try
    {
        if (password_verify($password, getSavedPasswordByUsername($username)))
        {
            // Sauvegarde des informations de l'utilisateur connecté en session
            $_SESSION['username'] = $username;
            $_SESSION['loggedIn'] = true;
            $_SESSION['userId'] = getUserIdByUserName($username);
            $_SESSION['emailUser'] = getEmailByUserId($_SESSION['userId']);
            $_SESSION['avatarSrc']=getavatar();
            $_SESSION['credit'] = getUserCredit();
            $_SESSION['level'] = getUserLevel($_SESSION['userId']);

            addGlobalEvent($username." vient de se connecter.");
            // Redirection vers la page d'accueil
            header("Location: /homePage.php" . createSuccessAlert("Vous êtes maintenant connecté."));
        }
        else
        {
            createFailureAlert("Le nom d'utilisateur ou le mot de passe est incorrect.");
        }
    }
    catch (Exception $e)
    {
        echo "Une erreur est survenue : ", $e->getMessage(), "\n";
    }
}

/**
 * Lance l'inscription.
 * @param string $avatarSrc La source de l'avatar
 * @param string $username Le nom d'utilisateur.
 * @param string $emailAddress L'adresse mail.
 * @param string $password Le mot de passe.
 * @param string $passwordConfirmation La confirmation de mot de passe.
 * @param array $languages Les langues.
 */
function register(string $avatarSrc, string $username, string $emailAddress, string $password, string $passwordConfirmation, array $languages): void
{
    try
    {
        // Vérifications
        $isValid = isValidUsername($username);
        $isValid = isValidEmailAddress($emailAddress) && $isValid;
        $isValid = isValidPassword($password) && $isValid;
        $isValid = isValidPasswordConfirmation($password, $passwordConfirmation) && $isValid;
        $isValid = isValidLanguages($languages) && $isValid;

        if ($isValid)
        {
            // Cryptage du mot de passe
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Ajout d'un utilisateur
            addUser($username, $emailAddress, $hashedPassword);
            addUserAvatar($emailAddress, $avatarSrc);
            addUserLanguages($emailAddress, $languages);
            addCreditUser($emailAddress);
            addLevelUser($emailAddress);
            addRankPointUser($emailAddress);

            // Envoi du mail de confirmation
            //$isSent = sendConfirmationEmail($emailAddress);
            $isSent = true;
            if ($isSent)
            {
                // Redirection vers la page de connexion
                $_SESSION["loggedIn"] = true;
                $_SESSION['avatarSrc'] = $avatarSrc;
                $_SESSION["username"] = $username;
                $_SESSION["emailUser"] = $emailAddress;
                $_SESSION['userId'] = getUserIdByUserName($username);
                $_SESSION['credit'] = getUserCredit();
                $_SESSION['level'] = getUserLevel($_SESSION['userId']);
                
                header("Location: /homePage.php" . createSuccessAlert("Votre inscription a été réalisée avec succès, vous avez gagné 100 NYT de bienvenue. Un mail de confirmation vous a été envoyé."));
            }
            else
            {
                // Supprime un utilisateur
                deleteUser($emailAddress);

                createFailureAlert("Votre inscription a échoué. Le mail de confirmation n'a pas pu être envoyé. Veuillez recommencer.");
            }
        }

    } catch (Exception $e) {

        if (isExistingUsername($emailAddress)){

            // Supprime un utilisateur
            deleteUser($emailAddress);
        }

        echo "Une erreur est survenue : ",  $e->getMessage(), "\n";
    }
}
/*

recupère avatar utilisateur

*/
function getavatar()
{
    $db = DataBase::getInstance();
    $queryExist = "SELECT valueAttribute from UserAttributes WHERE idUser = ".$_SESSION["userId"]." AND nameAttribute = 'urlAvatar';";
    $s = $db->prepare($queryExist);
    $s->execute();
    $tupleR = $s->fetch(PDO::FETCH_LAZY);
    $avatar=$tupleR['valueAttribute'];
    return $avatar;

}
/**
 * Récupère les crédits d'un utilisateur.
 */
function getUserCredit() {
  // Connexion à la base de données et récupération de l'instance créée
  $db = DataBase::getInstance();

  $query = "SELECT valueAttribute FROM UserAttributes WHERE nameAttribute = 'credit' AND idUser = ".$_SESSION['userId'].";";
  $s = DataBase::launchQuery($db, $query);
  $response = $s->fetch(PDO::FETCH_LAZY);

  $credit = 0;

  if ($s->rowCount() > 0 ) {
    $credit = intval($response["valueAttribute"]);

  } else {
    $query = "INSERT INTO UserAttributes (idUser, nameAttribute, valueAttribute) VALUES (" . $_SESSION["userId"] .", 'credit' , " . $db->quote(100) . ");";
    DataBase::launchQuery($db, $query);
    $credit = 100;
  }

  return $credit;

}

/**
 * Récupère le score d'un utilisateur.
 */
function getUserScore() {
  // Connexion à la base de données et récupération de l'instance créée
  $db = DataBase::getInstance();

  $query = "SELECT r.score FROM ranking r WHERE r.type = 1 AND r.idUser = ".$_SESSION['userId'].";";
  $s = DataBase::launchQuery($db, $query);
  $response = $s->fetch(PDO::FETCH_LAZY);

  $score = 0;

  if ($s->rowCount() > 0 ) {
    $score = intval($response["score"]);

  } 

  return $score;

}

/**
 * Récupère le classement d'un utilisateur.
 */
function getUserRank($userId, $type) {
  // Connexion à la base de données et récupération de l'instance créée
  $db = DataBase::getInstance();

  $query = "SELECT r.score, r.idUser FROM ranking r WHERE r.type = ".$type." ORDER BY r.score DESC;";

  $s = DataBase::launchQuery($db, $query);

  $rank = 1;

  if ($s->rowCount() > 0 ) {
    while ($rows = $s->fetch(PDO::FETCH_LAZY)) {
      if ($rows["idUser"] == $userId) {
        return $rank;
      }
      $rank = $rank + 1;
    }
  } else {

    $rank = -1;
  } 

  return $rank;

}

/**
 * Modifie le credit d'un utilisateur.
 * @param int $userId L'identifiant de l'utilisateur.
 * @param int $credit la nouvelle valeur du credit.
 */
function updateCredit(int $userId, int $credit) 
{
  // Connexion à la base de données et récupération de l'instance créée
  $db = DataBase::getInstance();

  // Modification du credit de l'utilisateur.
  $query = "UPDATE UserAttributes SET valueAttribute = " . $db->quote($credit) . " WHERE idUser = " . $userId . " AND nameAttribute = 'credit';";
  DataBase::launchQuery($db, $query);

}

/**
 * Lance la déconnexion.
 */
function logout():void
{
    try
    {
        // Suppression des informations de l'utilisateur en session
        session_destroy();

        // Redirection vers la page d'accueil
        header("Location: /homePage.php" . createSuccessAlert("Vous êtes maintenant déconnecté."));
    }
    catch (Exception $e)
    {
        echo "Une erreur est survenue : ",  $e->getMessage(), "\n";
    }
}

/**
 * Lance la demande de réinitialisation de mot de passe.
 * @param string $emailAddress L'adresse mail.
 */
function resetPassword(string $emailAddress): void
{
    $isValid = isExistingEmailAddress($emailAddress);

    if ($isValid)
    {
        $isSent = sendResetPasswordEmail($emailAddress);

        if ($isSent)
        {
            // Redirection vers la page de connexion
            header("Location: /homePage.php" . createSuccessAlert("Un mail de réinitialisation de mot de passe vous a été envoyé."));
        }
        else
        {
            createFailureAlert("Le mail de réinitialisation n'a pas pu être envoyé. Veuillez recommencer.");
        }
    }
}

/**
 * Lance la réinitialisation du mot de passe.
 * @param int $userId L'identifiant d'un utilisateur.
 * @param string $code Le code.
 * @param string $newPassword Le nouveau mot de passe.
 * @param string $passwordConfirmation La confirmation de mot de passe.
 */
function passwordReseted(int $userId, string $code, string $newPassword, string $passwordConfirmation): void
{
    try
    {
        if ($code == getSavedResetPasswordCode($userId))
        {
            $isValid = isValidNewPassword($newPassword);
            $isValid = isValidPasswordConfirmation($newPassword, $passwordConfirmation) && $isValid;

            if ($isValid)
            {
                updatePassword($userId, password_hash($newPassword, PASSWORD_DEFAULT));

                header("Location: /View/html/loginPage.php" . createSuccessAlert("Votre mot de passe a été réinitialisé avec succès."));
            }
        }
        else
        {
            // Redirection vers la page d'accueil
            header("Location: /View/html/loginPage.php" . createFailureAlert("Votre mot de passe n'a pas été réinitialisé, le lien est incorrect."));
        }
    }
    catch (Exception $e)
    {
        echo "Une erreur est survenue : ",  $e->getMessage(), "\n";
    }
}

/**
 * Modifie les informations d'un utilisateur.
 * @param int $userId L'identifiant d'un utilisateur.
 * @param string $userName Le nom d'utilisateur.
 * @param string $emailAddress L'adresse mail.
 * @param array $languages Les langues.
 */
function profile(string $avatarSrc, int $userId, string $userName, string $emailAddress, array $languages): void
{
    try
    {
        $isValid = $userName == "" || isValidUsername($userName, $userId);
        $isValid = $emailAddress == "" || isValidEmailAddress($emailAddress, $userId) && $isValid;
        $isValid = isValidLanguages($languages) && $isValid;

        if ($isValid)
        {
            $hasEmailChanged = $emailAddress != "" && !isExistingEmailAddress($emailAddress);
            $hasUserNameChanged = $userName != "" && !isExistingUsername($userName);

            updateUser($userId, $userName, $emailAddress);
            updateAvatar($userId, $avatarSrc);
            updateLanguages($userId, $languages);
            $_SESSION['avatarSrc'] = $avatarSrc;

            if ($hasUserNameChanged)
            {
                $_SESSION["username"] = $userName;
            }

            if ($hasEmailChanged)
            {
                $_SESSION["emailUser"] = $emailAddress;
                
                $isSent = sendConfirmationEmail($emailAddress);

                if ($isSent)
                {
                    
                    header("Location: /homePage.php" . createSuccessAlert("Les modifications ont bien été prises en compte. Un mail de confirmation d'adresse mail vous a été envoyé."));
                }
                else
                {
                    createFailureAlert("Les modifications ont bien été prises en compte. Le mail de réinitialisation n'a pas pu être envoyé.");
                }
            }

            header("Location: /homePage.php" . createSuccessAlert("Les modifications ont bien été prises en compte."));
        }
    }
    catch (Exception $e)
    {
        echo "Une erreur est survenue : ",  $e->getMessage(), "\n";
    }
}

/**
 * Lance le changement de mot de passe.
 * @param int $userId L'identifiant d'un utilisateur.
 * @param string $actualPassword Le mot de passe actuel.
 * @param string $newPassword Le nouveau mot de passe.
 * @param string $passwordConfirmation La confirmation de mot de passe.
 */
function changePassword(int $userId, string $actualPassword, string $newPassword, string $passwordConfirmation): void
{
    try
    {
        $isValid = isValidActualPassword($actualPassword, $userId);
        $isValid = isValidNewPassword($newPassword) && $isValid;
        $isValid = isValidPasswordConfirmation($newPassword, $passwordConfirmation) && $isValid;

        if ($isValid)
        {
            updatePassword($userId, password_hash($newPassword, PASSWORD_DEFAULT));
            session_destroy();

            header("Location: /View/html/loginPage.php" . createSuccessAlert("Votre mot de passe a été modifié avec succès."));
        }

    }
    catch (Exception $e)
    {
        echo "Une erreur est survenue : ",  $e->getMessage(), "\n";
    }
}

/**
 * Envoie un mail de confirmation d'adresse mail.
 * @param string $emailAddress L'adresse mail.
 * @return bool Vrai si le mail a été envoyé, Faux sinon.
 */
function sendConfirmationEmail(string $emailAddress): bool
{
    $userId = getUserIdByEmailAddress($emailAddress);

    $code = createEmailConfirmationCode($userId);
    $url = FileHelper::getBaseUrl() . "View/html/confirmEmail.php?code=$code&userId=$userId";

    $subject = "Vérification d'adresse mail.";

    $message = "<p>Bonjour, Vous avez récement créé un compte sur WordZ, veuillez cliquer sur le lien suivant pour valider votre compte et bénéficier de tous les avantages du jeu!</p>";
    $message .= "<p><a class='btn btn-success' href='" . $url . "'>Valider votre compte</a></p>";
    $message .= "<p>Cordialement, l'équipe de WordZ.</p>";

    return EmailHelper::sendMail($emailAddress, $subject, $message);
}

/**
 * Envoie un mail de réinitialisationde mot de passe.
 * @param string $emailAddress L'adresse mail.
 * @return bool Vrai si le mail a été envoyé, Faux sinon.
 */
function sendResetPasswordEmail(string $emailAddress): bool
{
    $userId = getUserIdByEmailAddress($emailAddress);

    $code = createResetPasswordCode($userId);
    $url = FileHelper::getBaseUrl() . "View/html/passwordReseted.php?code=$code&userId=$userId";

    $subject = "Réinitialisation de mot de passe.";

    $message = "<p>Bonjour, Vous avez demandé une réinitialisation de votre mot de passe sur le jeu WordZ, suivez ce lien pour modifier votre mot de passe.</p>";
    $message .= "<p><a class='btn btn-success' href='" . $url . "'>Modifier votre mot de passe</a></p>";
    $message .= "<p>Cordialement, l'équipe de WordZ.</p>";

    return EmailHelper::sendMail($emailAddress, $subject, $message);
}

/**
 * Confirme l'adresse mail d'un utilisateur.
 * @param int $userId L'identifiant de l'utilisateur.
 * @param string $code Le code.
 */
function emailConfirmation(int $userId, string $code): void
{
    try
    {
        if ($code == getSavedConfirmationCode($userId))
        {
            // Redirection vers la page d'accueil
            header("Location: /View/html/loginPage.php" . createSuccessAlert("Votre adresse mail a été confirmée avec succès."));
        }
        else
        {
            // Redirection vers la page d'accueil
            header("Location: /View/html/loginPage.php" . createFailureAlert("Votre adresse mail n'a pas été confirmée, le lien est incorrect."));
        }
    }
    catch (Exception $e)
    {
        echo "Une erreur est survenue : ",  $e->getMessage(), "\n";
    }
}

/**
 * Génère et enregistre un code de confirmation d'adresse mail.
 * @param int $userId L'identifiant d'un utilisateur.
 * @return string Le code de confirmation.
 */
function createEmailConfirmationCode(int $userId): string
{
    $code = generateCode();

    if (hasConfirmationCode($userId))
    {
        // Modification du code de confirmation d'adresse mail
        updateConfirmationCode($userId, $code);
    }
    else
    {
        // Ajout d'un code de confirmation d'adresse mail
        addConfirmationCode($userId, $code);
    }

    return $code;
}

/**
 * Génère et enregistre un code de réinitialisation de mot de passe.
 * @param int $userId L'identifiant d'un utilisateur.
 * @return string Le code de réinitialisation.
 */
function createResetPasswordCode(int $userId): string
{
    $code = generateCode();

    if (hasResetPasswordCode($userId))
    {
        // Modification du code de réinitialisation de mot de passe
        updateResetPasswordCode($userId, $code);
    }
    else
    {
        // Ajout d'un code de réinitialisation de mot de passe
        addResetPasswordCode($userId, $code);
    }

    return $code;
}

/**
 * Génère un code.
 * @return string Le code généré.
 */
function generateCode(): string
{
    $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $charactersLength = strlen($characters);
    $code = "";

    for ($i = 0; $i < 20; $i++) {
        $code .= $characters[rand(0, $charactersLength - 1)];
    }

    return $code;
}

/**
 * Gère le passage de niveaux d'un utilisateur.
 * @param int $userId L'identifiant d'un utilisateur.
 */
function handleLevel(int $userId): void
{
    $level = getUserLevel($userId);
    $points = getUserScore();

    $hasFirstStep = $points >= 1000;

    if ($level == 0 && $hasFirstStep) {
        $level++;
    }

    if ($level > 0) {

        $lastStep = 1000 * $level;
        $nextStep = 1000 * ($level + 1);
        $newStep = $lastStep + $nextStep;

        while ($points >= $newStep) {

            $level++;

            $lastStep = 1000 * $level;
            $nextStep = 1000 * ($level + 1);
            $newStep = $lastStep + $nextStep;
        }
    }

    if ($level > getUserLevel($userId)) {
        updateLevel($userId, $level);
        addUserEvent($userId, "Vous êtes passé au niveau : ".$level." , vous avez gagné 100 NYT.");

        $oldCredits = getUserCredit();
        $newCredit = $oldCredits + (100 * $level);
        updateCredit($userId, $newCredit);

        $_GET["alertMessage"] = "Bravo, vous venez de passer au niveau " . $level . "!";
        $_GET["alertType"] = "success";
    }

    $_SESSION["level"] = $level;
}
