<?php

namespace App\Controller\Authentification;

use App\Service\UserConnectionService;
use App\Utils\Cookies;
use App\Utils\Security;
use App\Controller\AbstractController;
use App\Database\DataBaseSingleton;
use App\Service\EmailService;
use App\Service\UserService;

/**
 * The PasswordForgotController class is responsible for handling requests related to the index page.
 * This class be able to send an email to the user to reset his password.
 */
class PasswordForgotController extends AbstractController
{

    private EmailService $emailService;
    private UserConnectionService $userConnectionService;
    private UserService $userService;

    /**
     * Constructs a new instance of the PasswordForgotController class.
     */
    public function __construct()
    {
        parent::__construct("Authentification/Mot_de_passe_oublie");


        if ($_SERVER["REQUEST_URI"] === "/forgot_password") {
            $this->userService = DataBaseSingleton::getInstance();
            $this->emailService = new EmailService();
            $this->userConnectionService = new UserConnectionService();


            // IF CONNECTED REDIRECT TO HOME
            Cookies::exists("user") ? header("Location: /") : null;

            if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["email"])) {
                $this->handlePostRequest();
            } else if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $this->data['message'] = "Veuillez entrer une adresse email.";
            }
        }
    }

    /**
     * Handles a POST request.
     */
    private function handlePostRequest()
    {
        $email = Security::sanitizeInput($_POST["email"]);
        $user = $this->userService->getUserByEmail($email);

        if ($user) {
            // Send email
            $to = $email;
            $subject = "Réinitialisation de votre mot de passe";


            // Store the token in the database associated with the user
            $token = Security::generateToken();
            $this->userConnectionService->storeUserToken($user, $token);


            $resetPasswordUrl = "http://localhost/change_password?token=$token";

            ob_start();
            include 'template\views\reset_password_email.html';
            $message = ob_get_clean();

            $this->emailService->sendEmail($to, $user->getFirstName(), $subject, $message, $message);
        }

        $this->data['message'] = "Si un compte est associé à cet email, un email de réinitialisation de mot de passe vous a été envoyé.";
    }
}
