<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';
require_once 'views/View.php';


/**
 *
 */
class ControllerService
{
    private $view;

    public function __construct()
    {
        if (isset($_GET['contact'])) {
            $this->contact();
        }
        if (isset($_GET['send'])) {
            $this->sendEmail();
        } else {
            throw new \Exception("Page Introuvable");
        }
    }

    public function contact()
    {
        $this->view = new View('Contact');
        $this->view->generate(array());
    }

    public function sendEmail()
    {
        $mail_username = $_ENV['MAIL_USERNAME'];
        $mail_password = $_ENV['MAIL_PASSWORD'];
        $newFields = array_map('htmlspecialchars', $_POST);
        // Valider les données soumises
        $errors = [];

        if (empty($newFields['firstName'])) {
            $errors['firstName'] = "Le Prénom est obligatoire";
        }
        if (empty($newFields['email'])) {
            $errors['email'] = "L'adresse email est obligatoire";
        } elseif (!filter_var($newFields['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "L'adresse email n'est pas valide";
        }
        if (empty($newFields['subject'])) {
            $errors['subject'] = "Merci de rentrer un objet de message";
        }
        if (empty($newFields['message'])) {
            $errors['message'] = "Merci de rentrer un message";
        }

        if (empty($errors)) {
            $firstName = $newFields['firstName'];
            $email = $newFields['email'];
            $subject = $newFields['subject'];
            $message = $newFields['message'];
        }
        //Create a new PHPMailer instance

        $mail = new PHPMailer;

        try {

            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $mail_username;                     //SMTP username
            $mail->Password   = $mail_password;                               //SMTP password
            $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('vod52m@gmail.com', 'Administrateur AFID');
            $mail->addAddress($email, $firstName);     //Add a recipient
            //$mail->addAddress('ellen@example.com');               //Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        header('Location: service&contact');
    }
}
