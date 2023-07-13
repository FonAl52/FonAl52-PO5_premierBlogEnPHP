<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';
require_once 'views/View.php';


class ControllerService
{


    /**
     * View instance.
     *
     * @var View
     */
    private $view;

    
    /**
     * ControllerService constructor.
     * Initializes the ControllerComment object.
     *
     * @throws \Exception If the page is not found.
     *
     * @return void
     */
    public function __construct()
    {
        if (isset($_GET['contact']) === TRUE) {
            $this->contact();
        }
        if (isset($_GET['send']) === TRUE) {
            $this->sendEmail();
        } else {
            throw new \Exception("Page Introuvable");
        }

    }//end __construct()


    /**
     * Display contact formular.
     *
     * @return void
     */
    public function contact()
    {
        $this->view = new View('Contact');
        $this->view->generate([]);
    
    }//end contact()


    /**
     * Send email with contact formular.
     *
     * @return void
     */
    public function sendEmail()
    {
        $mail_username = $_ENV['MAIL_USERNAME'];
        $mail_password = $_ENV['MAIL_PASSWORD'];
        $newFields = array_map('htmlspecialchars', $_POST);

        // Valider les données soumises.
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

        // Create a new PHPMailer instance.
        $mail = new PHPMailer;

        try {

            // Server settings.
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $mail_username;
            $mail->Password   = $mail_password;
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;

            // Recipients.
            $mail->setFrom('vod52m@gmail.com', 'Administrateur AFID');
            $mail->addAddress($email, $firstName);
            //$mail->addAddress('ellen@example.com');     
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            // Attachments.
            //$mail->addAttachment('/var/tmp/file.tar.gz');
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');

            // Content.
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        header('Location: service&contact');

    }//end sendEmail()


}
