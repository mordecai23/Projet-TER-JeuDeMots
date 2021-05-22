<?php

use PHPMailer\PHPMailer\PHPMailer;

// Ajout des fichiers requis
require_once "FileHelper.php";
require_once FileHelper::buildPath(array("libs", "PHPMailer", "src", "Exception.php"));
require_once FileHelper::buildPath(array("libs", "PHPMailer", "src", "PHPMailer.php"));
require_once FileHelper::buildPath(array("libs", "PHPMailer", "src", "SMTP.php"));

/**
 * Ajoute des méthodes pour envoyer des mails.
 */
class EmailHelper {

    /**
     * Envoie un nouveau mail.
     */
    public static function sendMail($recipient, $subject, $message) {

        // Création du mail
        $mail = new PHPMailer;

        $mail->isSMTP(); 
        $mail->SMTPDebug = 0;
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;

        // Gestion de la connexion au gestionnaire de mails
        $mail->Username = 'wordz.system@gmail.com';
        $mail->Password = 'wordz.system01';

        // Gestion du contenu du mail
        $mail->setFrom('wordz.system@gmail.com', 'Systeme WordZ');
        $mail->addAddress($recipient);
        $mail->Subject = $subject;
        $mail->msgHTML($message);

        // Gestion des options
        $mail->CharSet = 'UTF-8';
        $mail->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true));
        
        // Envoi du mail
        return $mail->send();
    }
}

?>