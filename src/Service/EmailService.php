<?php

namespace App\Service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EmailService
{
    private $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        $this->setup();
    }

    private function setup()
    {
        $this->mailer->isSMTP();
        $this->mailer->Host = 'smtp.gmail.com';
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = 'noreply.eventit@gmail.com';
        $this->mailer->Password = 'hadx rhfd csqo hwxj';
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = 587;
    }

    public function sendEmail($to, $toName, $subject, $htmlContent, $altBody)
    {
        try {
            $this->mailer->setFrom('noreply.eventit@gmail.com', 'Event IT');
            $this->mailer->addAddress($to, $toName);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $htmlContent;
            $this->mailer->AltBody = $altBody;

            $this->mailer->send();
            return 'Message envoyé';
        } catch (Exception $e) {
            return "Message non envoyé. Erreur: {$this->mailer->ErrorInfo}";
        }
    }
}
