<?php

// Ajout des fichiers requis
require_once $_SERVER['DOCUMENT_ROOT']."/fichiers_php/ConnectionBDD.php";

/**
 * Récupère le mot de passe d'un utilisateur en base.
 * @param string $username Le nom d'un utilisateur.
 * @return string Le mot de passe de l'utilisateur.
 */
function getSavedPasswordByUsername(string $username): string
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    $query = "SELECT password FROM User WHERE userName = " . $db->quote(trim($username)) . ";";
    $s = DataBase::launchQuery($db, $query);

    $response = $s->fetch(PDO::FETCH_LAZY);
    return $response["password"] ?? "";
}

/**
 * Récupère le mot de passe d'un utilisateur en base.
 * @param int $userId L'identifiant d'un utilisateur.
 * @return string Le mot de passe de l'utilisateur.
 */
function getSavedPasswordById(int $userId): string
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    $query = "SELECT password FROM User WHERE idUser = " . $userId . ";";
    $s = DataBase::launchQuery($db, $query);

    $response = $s->fetch(PDO::FETCH_LAZY);
    return $response["password"];
}

/**
 * Récupère le code de confirmation d'un utilisateur en base.
 * @param int $userId L'idenfitiant de l'utilisateur.
 * @return string Le code.
 */
function getSavedConfirmationCode(int $userId): string
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    $query = "SELECT valueAttribute FROM UserAttributes WHERE idUser = " . $userId . " AND nameAttribute = 'confirmationCode' ;";
    $s = DataBase::launchQuery($db, $query);

    $response = $s->fetch(PDO::FETCH_LAZY);
    return $response["valueAttribute"];
}

/**
 * Récupère le niveau d'un utilisateur en base.
 * @param int $userId L'idenfitiant de l'utilisateur.
 * @return string Le niveau.
 */
function getUserLevel(int $userId): int
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    $query = "SELECT valueAttribute FROM UserAttributes WHERE idUser = " . $userId . " AND nameAttribute = 'level' ;";
    $s = DataBase::launchQuery($db, $query);

    $response = $s->fetch(PDO::FETCH_LAZY);
    return intval($response["valueAttribute"]);
}

/**
 * Récupère les points d'un utilisateur en base.
 * @param int $userId L'idenfitiant de l'utilisateur.
 * @return int Les points.
 */
function getUserPoints(int $userId): int
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    $query = "SELECT score FROM Ranking WHERE idUser = " . $userId . " AND type = 1;";
    $s = DataBase::launchQuery($db, $query);

    $response = $s->fetch(PDO::FETCH_LAZY);
    return $response["score"];
}

/**
 * Récupère le code de réinitialisation de mot de passe d'un utilisateur en base.
 * @param int $userId L'idenfitiant de l'utilisateur.
 * @return string Le code.
 */
function getSavedResetPasswordCode(int $userId): string
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    $query = "SELECT valueAttribute FROM UserAttributes WHERE idUser = " . $userId . " AND nameAttribute = 'resetPasswordCode' ;";
    $s = DataBase::launchQuery($db, $query);

    $response = $s->fetch(PDO::FETCH_LAZY);
    return $response["valueAttribute"];
}

/**
 * Récupère l'identifiant d'un utilisateur à partir de son adresse mail.
 * @param string $emailAddress L'adresse mail.
 * @return int L'identifiant d'un utilisateur.
 */
function getUserIdByEmailAddress(string $emailAddress): int
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    $query = "SELECT idUser FROM User WHERE email = " . $db->quote($emailAddress) . ";";
    $s = DataBase::launchQuery($db, $query);

    $response = $s->fetch(PDO::FETCH_LAZY);
    return $response["idUser"];
}

/**
 * Récupère l'identifiant d'un utilisateur à partir de son nom d'utilisateur.
 * @param string $userName Le nom d'utilisateur.
 * @return int L'identifiant d'un utilisateur.
 */
function getUserIdByUserName(string $userName): int
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    $query = "SELECT idUser FROM User WHERE userName = " . $db->quote($userName) . ";";
    $s = DataBase::launchQuery($db, $query);

    $response = $s->fetch(PDO::FETCH_LAZY);
    return $response["idUser"];
}

/**
 * Récupère l'email d'un utilisateur à partir de son identifiant.
 * @param int $userId L'identifiant utilisateur.
 * @return string l'email d'un utilisateur.
 */
function getEmailByUserId(int $userId) : string{
  // Connexion à la base de données et récupération de l'instance créée
  $db = DataBase::getInstance();

  $query = "SELECT email FROM User WHERE idUser = " . $userId . ";";
  $s = DataBase::launchQuery($db, $query);

  $response = $s->fetch(PDO::FETCH_LAZY);
  return $response["email"];

}
/**
 * Ajoute un nouvel utilisateur.
 * @param string $username Le nom d'utilisateur.
 * @param string $emailAddress L'adresse mail.
 * @param string $hashedPassword Le mot de passe crypté.
 */
function addUser(string $username, string $emailAddress, string $hashedPassword)
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    $query = "INSERT INTO User (userName, password, email) VALUES (" . $db->quote($username) . ", " . $db->quote($hashedPassword) . ", " . $db->quote($emailAddress) . ");";
    DataBase::launchQuery($db, $query);
}

/**
 * Ajoute l'url avatar de l'utilisateur
 * @param string $emailAddress L'adresse mail.
 * @param string $avatarSrc La source de l'avatar.
 */
function addUserAvatar(string $emailAddress, string $avatarSrc)
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    $userId = getUserIdByEmailAddress($emailAddress);

    $query = "INSERT INTO UserAttributes (idUser, nameAttribute, valueAttribute) VALUES (" . $userId .", 'urlAvatar' , " . $db->quote($avatarSrc) . ");";
    DataBase::launchQuery($db, $query);
}

/**
 * Ajoute des crédits à l'utilisateur (100 NYT).
 * @param string $emailAddress L'adresse mail.
 */
function addCreditUser(string $emailAddress)
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    $userId = getUserIdByEmailAddress($emailAddress);

    $query = "INSERT INTO UserAttributes (idUser, nameAttribute, valueAttribute) VALUES (" . $userId .", 'credit' , " . $db->quote(100) . ");";
    DataBase::launchQuery($db, $query);
}

/* Ajoute des crédits à l'utilisateur (100 NYT).
 * @param string $emailAddress L'adresse mail.
 */
function addLevelUser(string $emailAddress)
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    $userId = getUserIdByEmailAddress($emailAddress);

    $query = "INSERT INTO UserAttributes (idUser, nameAttribute, valueAttribute) VALUES (" . $userId .", 'level' , " . $db->quote(0) . ");";
    DataBase::launchQuery($db, $query);
}

/**
 * Ajoute les points et le rang de l'utilisateur. (Type 1 : rang global, Type 2 : rang mensuel, Type 3 : rang hebdomadaire)
 * @param string $emailAddress l'adresse mail.
 */
function addRankPointUser($emailAddress)
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    $userId = getUserIdByEmailAddress($emailAddress);

    $query = "INSERT INTO ranking (idUser, score, type) VALUES (".$userId.", 0, 1) , (".$userId.", 0, 2) , (".$userId.", 0, 3);";

    DataBase::launchQuery($db, $query);
}

/**
 * Ajoute la date de connexion d'un utilisateur.
 * @param int $userId l'identifiant utilisateur.
 */
function addDateConnectionUser($userId)
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    $dateRegister = new DateTime();
    $dateToString = date('dd/mm/Y H:i:s');

    $query = "INSERT INTO UserAttributes (idUser, nameAttribute, valueAttribute) VALUES (" . $userId .", 'connectionDate' , " . $dateToString . ");";
    DataBase::launchQuery($db, $query);
}

/**
 * Vérifie le bonus de crédit journalier d'un utilisateur.
 * @param $userId L'identifiant d'un utilisateur.
 */
function checkDailyCredit($userId)
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

}


/**
 * Supprime un utilisateur.
 * @param string $emailAddress L'adresse mail.
 */
function deleteUser(string $emailAddress)
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    $query = "DELETE FROM User WHERE email = " . $db->quote($emailAddress) . ";";
    DataBase::launchQuery($db, $query);
}

/**
 * Ajoute les langues à un utilisateur.
 * @param string $emailAddress L'adresse mail de l'utilisateur.
 * @param array $languages Les langues.
 */
function addUserLanguages(string $emailAddress, array $languages)
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    $userId = getUserIdByEmailAddress($emailAddress);

    foreach($languages as $language)
    {
        // Récupération de l'identifiant d'une langue
        $query = "SELECT idNode FROM Node WHERE type = 2 AND value = " . $db->quote($language) . ";";
        $s = DataBase::launchQuery($db, $query);

        $response = $s->fetch(PDO::FETCH_LAZY);
        $languageId = $response["idNode"];

        // Ajout de la liaison entre un utilisateur et une langue
        $query = "INSERT INTO UserNode (idUser, idNode) VALUES (" . $userId . ", " . $languageId . ")";
        DataBase::launchQuery($db, $query);
    }
}

/**
 * Récupère les langues d'un utilisateur.
 * @param int $userId L'identifiant d'un utilisateur.
 * @return array Les langues.
 */
function getUserLanguages(int $userId): array
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    $query = "SELECT idNode FROM UserNode WHERE idUser = " . $userId . ";";
    $s = DataBase::launchQuery($db, $query);

    $languages = array();

    while ($response = $s->fetch(PDO::FETCH_LAZY))
    {
        $query = "SELECT value FROM Node WHERE type = 2 AND idNode = " . $response["idNode"] . ";";
        $languageQuery = DataBase::launchQuery($db, $query);

        $languageResponse = $languageQuery->fetch(PDO::FETCH_LAZY);
        $value = $languageResponse["value"] ?? null;

        if ($value != null)
        {
            array_push($languages, $value);
        }
    }

    return $languages;
}

/**
 * Ajoute un evenement global
 * @param string $message Message.
 */
function addGlobalEvent($message) {

  // Connexion à la base de données et récupération de l'instance créée
  $db = DataBase::getInstance();

  $query = "INSERT INTO EventWordz (valueEvent) values (".$db->quote($message).");";
  $s = DataBase::launchQuery($db, $query);

}

/**
 * Ajoute un evenement global
 * @param int $userId L'identifiant d'un utilisateur.
 * @param string $message Message.
 */
function addUserEvent($userId, $message) {

  // Connexion à la base de données et récupération de l'instance créée
  $db = DataBase::getInstance();

  $query = "INSERT INTO EventWordz (valueEvent, idUser) values (".$db->quote($message).", ".$userId.");";
  $s = DataBase::launchQuery($db, $query);

}

/**
 * Récupère les 10 derniers évenements de l'utilisateur.
 */
function getUserEvents() {
  // Connexion à la base de données et récupération de l'instance créée
  $db = DataBase::getInstance();

  $query = "SELECT valueEvent, dateEvent FROM EventWordz WHERE idUser = ".$_SESSION["userId"]. " ORDER BY dateEvent DESC LIMIT 10;";
  $s = DataBase::launchQuery($db, $query);
  
  if ($s->rowCount() > 0 ) {
    while ($rows = $s->fetch(PDO::FETCH_LAZY)) {
      $date = DateTime::createFromFormat('Y-m-d H:i:s', $rows["dateEvent"]);
      $new_time = date("Y-m-d H:i:s", strtotime('+2 hours', strtotime($date->format('Y-m-d H:i:s'))));
      echo '<div class="toast " role="alert" aria-live="assertive" aria-atomic="true" style="opacity: 1;">
              <div class="toast-header">
                <strong class="mr-auto">Mes evenements</strong>
                <small class="text-muted">'.$new_time.'</small>
              </div>
              <div class="toast-body bg-primary">
              '.$rows["valueEvent"].'
              </div>
            </div>';
    }
  }
}

/**
 * Récupère les 10 derniers évenements de l'utilisateur.
 */
function getGlobalEvents() {
  // Connexion à la base de données et récupération de l'instance créée
  $db = DataBase::getInstance();

  $query = "SELECT valueEvent, dateEvent FROM EventWordz WHERE idUser is NULL ORDER BY dateEvent DESC LIMIT 30;";
  $s = DataBase::launchQuery($db, $query);
  
  if ($s->rowCount() > 0 ) {
    while ($rows = $s->fetch(PDO::FETCH_LAZY)) {
      $date = DateTime::createFromFormat('Y-m-d H:i:s', $rows["dateEvent"]);
      $new_time = date("Y-m-d H:i:s", strtotime('+2 hours', strtotime($date->format('Y-m-d H:i:s'))));
      echo '<div class="toast " role="alert" aria-live="assertive" aria-atomic="true" style="opacity: 1;">
              <div class="toast-header">
                <strong class="mr-auto">Evenements globaux</strong>
                <small class="text-muted">'.$new_time.'</small>
              </div>
              <div class="toast-body bg-secondary">
              '.$rows["valueEvent"].'
              </div>
            </div>';
    }
  }
}

/**
 * Modifie le code de confirmation d'un utilisateur.
 * @param int $userId L'identifiant de l'utilisateur.
 * @param string $code Le nouveau code.
 */
function updateConfirmationCode(int $userId, string $code): void
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    // Modification du code de confirmation d'adresse mail
    $query = "UPDATE UserAttributes SET valueAttribute = " . $db->quote($code) . " WHERE idUser = " . $userId . " AND nameAttribute = 'confirmationCode';";
    DataBase::launchQuery($db, $query);
}

/**
 * Ajoute un code de confirmation à un utilisateur.
 * @param int $userId L'identifiant de l'utilisateur.
 * @param string $code Le code.
 */
function addConfirmationCode(int $userId, string $code): void
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    $query = "INSERT INTO UserAttributes (idUser, nameAttribute, valueAttribute) VALUES (" . $userId . ", 'confirmationCode', " . $db->quote($code) . ")";
    DataBase::launchQuery($db, $query);
}

/**
 * Modifie le code de réinitialisation de mot de passe d'un utilisateur.
 * @param int $userId L'identifiant de l'utilisateur.
 * @param string $code Le nouveau code.
 */
function updateResetPasswordCode(int $userId, string $code): void
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    // Modification du code de réinitialisation de mot de passe
    $query = "UPDATE UserAttributes SET valueAttribute = " . $db->quote($code) . " WHERE idUser = " . $userId . " AND nameAttribute = 'resetPasswordCode';";
    DataBase::launchQuery($db, $query);
}

/**
 * Modifie le niveau d'un utilisateur.
 * @param int $userId L'identifiant de l'utilisateur.
 * @param int $level Le niveau.
 */
function updateLevel(int $userId, int $level): void
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    // Modification du code de réinitialisation de mot de passe
    $query = "UPDATE UserAttributes SET valueAttribute = " . $db->quote($level) . " WHERE idUser = " . $userId . " AND nameAttribute = 'level';";
    DataBase::launchQuery($db, $query);
}

/**
 * Ajoute un code de réinitialisation de mot de passe à un utilisateur.
 * @param int $userId L'identifiant de l'utilisateur.
 * @param string $code Le code.
 */
function addResetPasswordCode(int $userId, string $code): void
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    $query = "INSERT INTO UserAttributes (idUser, nameAttribute, valueAttribute) VALUES (" . $userId . ", 'resetPasswordCode', " . $db->quote($code) . ")";
    DataBase::launchQuery($db, $query);
}

/**
 * Permet de savoir si un nom d'utilisateur est déjà utilisé.
 * @param string $username Le nom d'utilisateur.
 * @param int|null $userId L'identifiant d'un utilisateur.
 * @return bool Vrai si le nom d'utilisateur est déjà utilisé, Faux sinon.
 */
function isExistingUsername(string $username, int $userId = null): bool
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    // Récupération d'un utilisateur
    if ($userId == null)
    {
        $query = "SELECT * FROM User WHERE userName = " . $db->quote($username) . ";";
    }
    else
    {
        $query = "SELECT * FROM User WHERE userName = " . $db->quote($username) . " AND idUser != " . $userId . ";";
    }

    $s = DataBase::launchQuery($db, $query);

    return $s->fetchColumn() > 0;
}

/**
 * Permet de savoir si une adresse mail est déjà utilisée.
 * @param string $emailAddress L'adresse mail.
 * @param int|null $userId L'identifiant d'un utilisateur.
 * @return bool Vrai si l'adresse mail est déjà utilisée, Faux sinon.
 */
function isExistingEmailAddress(string $emailAddress, int $userId = null): bool
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    // Récupération d'un utilisateur
    if ($userId == null)
    {
        $query = "SELECT * FROM User WHERE email = " . $db->quote($emailAddress) . ";";
    }
    else
    {
        $query = "SELECT * FROM User WHERE email = " . $db->quote($emailAddress) . " AND idUser != " . $userId . ";";
    }

    $s = DataBase::launchQuery($db, $query);

    return $s->fetchColumn() > 0;
}

/**
 * Permet de savoir si un utilisateur possède déjà un code de confirmation.
 * @param int $userId L'identifiant de l'utilisateur.
 * @return bool Vrai si l'utilisateur possède déjà un code de confirmation, Faux sinon.
 */
function hasConfirmationCode(int $userId): bool
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    // Récupération d'un code de confirmation
    $query = "SELECT * FROM UserAttributes WHERE idUser = " . $userId . " AND nameAttribute = 'confirmationCode';";
    $s = DataBase::launchQuery($db, $query);

    return $s->fetchColumn() > 0;
}

/**
 * Permet de savoir si un utilisateur possède déjà un code de réinitialisation de mot de passe.
 * @param int $userId L'identifiant de l'utilisateur.
 * @return bool Vrai si l'utilisateur possède déjà un code de réinitialisation de mot de passe, Faux sinon.
 */
function hasResetPasswordCode(int $userId): bool
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    // Récupération d'un code de confirmation
    $query = "SELECT * FROM UserAttributes WHERE idUser = " . $userId . " AND nameAttribute = 'resetPasswordCode';";
    $s = DataBase::launchQuery($db, $query);

    return $s->fetchColumn() > 0;
}

/**
 * Lance la modification d'un mot de passe en base.
 * @param int $userId L'identifiant de l'utilisateur.
 * @param string $password Le mot de passe.
 */
function updatePassword(int $userId, string $password): void
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    $query = "UPDATE User SET password = " . $db->quote($password) . " WHERE idUser = " . $userId . ";";
    DataBase::launchQuery($db, $query);
}

/**
 * Lance la modification d'un utilisateur.
 * @param int $userId L'identifiant d'un utilisateur.
 * @param string $username Le nom d'utilisateur.
 * @param string $emailAddress L'adresse mail.
 */
function updateUser(int $userId, string $username, string $emailAddress)
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    if ($username != "")
    {
        $query = "UPDATE User SET userName = " . $db->quote($username) . " WHERE idUser = " . $userId . ";";
        DataBase::launchQuery($db, $query);
    }

    if ($emailAddress != "")
    {
        $query = "UPDATE User SET email = " . $db->quote($emailAddress) . " WHERE idUser = " . $userId . ";";
        DataBase::launchQuery($db, $query);
    }
}

/**
 * Lance la modification d'un avatar de l'utilisateur.
 * @param int $userId L'identifiant d'un utilisateur.
 * @param string $avatarSrc L'avatar de l'utilisateur.
 */
function updateAvatar(int $userId, string $avatarSrc)
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    if ($avatarSrc != "")
    {
        $query = "UPDATE UserAttributes SET valueAttribute = '" . $avatarSrc . "' WHERE nameAttribute = 'urlAvatar' AND idUser = " . $userId . ";";
        DataBase::launchQuery($db, $query);
    }

}

function updateLanguages(int $userId, array $languages)
{
    // Connexion à la base de données et récupération de l'instance créée
    $db = DataBase::getInstance();

    // Supprime les anciennes langues
    $query = "DELETE FROM UserNode WHERE idUser = " . $userId . " AND score IS NULL;";
    DataBase::launchQuery($db, $query);

    // Ajoute les nouvelles langues
    foreach($languages as $language)
    {
        // Récupération de l'identifiant d'une langue
        $query = "SELECT idNode FROM Node WHERE type = 2 AND value = " . $db->quote($language) . ";";
        $s = DataBase::launchQuery($db, $query);

        $response = $s->fetch(PDO::FETCH_LAZY);
        $languageId = $response["idNode"];

        // Ajout de la liaison entre un utilisateur et une langue
        $query = "INSERT INTO UserNode (idUser, idNode) VALUES (" . $userId . ", " . $languageId . ")";
        DataBase::launchQuery($db, $query);
    }
}