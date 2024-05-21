<?php

namespace App\Service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EmailService
{
    private $mailer;

    private const SMTP_HOST = 'smtp.gmail.com';
    private const SMTP_USERNAME = 'noreply.eventit@gmail.com';
    private const SMTP_PASSWORD = 'hadx rhfd csqo hwxj';
    private const SMTP_PORT = 587;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        $this->setup();
    }

    private function setup()
    {
        $this->mailer->isSMTP();
        $this->mailer->CharSet = 'UTF-8';
        $this->mailer->Host = self::SMTP_HOST;
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = self::SMTP_USERNAME;
        $this->mailer->Password = self::SMTP_PASSWORD;
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = self::SMTP_PORT;
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
