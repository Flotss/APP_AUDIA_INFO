<?php

namespace App\Controller;

use App\Service\UserConnectionService;
use App\Utils\Cookies;
use App\Utils\Security;

/**
 * The ConnexionController class is responsible for handling requests related to the index page.
 */
class ConnexionController extends AbstractController
{

    private UserConnectionService $userConnectionService;

    /**
     * Constructs a new instance of the ConnexionController class.
     */
    public function __construct()
    {
        parent::__construct("Connexion_Inscription/Inscription");
        $this->userConnectionService = new UserConnectionService();

        // IF CONNECTED REDIRECT TO HOME
        Cookies::exists("user") ? header("Location: /") : null;

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["actionLogin"])) {
            $this->handlePostRequest();
        }
    }

    /**
     * Handles a POST request.
     */
    private function handlePostRequest()
    {
        if ($_POST["actionLogin"] === "connection") {
            $this->handleConnection();
            return;
        }

        if ($_POST["actionLogin"] === "inscription") {
            $this->handleInscription();
            return;
        }

        throw new \Exception("Invalid action.");
    }

    private function handleConnection()
    {
        // TODO : CHECK IF EMAIL AND PASSWORD ARE VALID
        $email = Security::sanitizeInput($_POST["email"]);
        $password = Security::sanitizeInput($_POST["password"]);

        $isLog = $this->userConnectionService->loginUser($email, $password);

        if ($isLog) {
            header("Location: /");
        } else {
            $this->data['message'] = "Email ou mot de passe incorrect";
        }
    }

    private function handleInscription()
    {
        $email = Security::sanitizeInput($_POST["email"]);
        $password = Security::sanitizeInput($_POST["password"]);
        $username = Security::sanitizeInput($_POST["username"]);
        $firstName = Security::sanitizeInput($_POST["firstName"]);
        $lastName = Security::sanitizeInput($_POST["lastName"]);
        $phone = Security::sanitizeInput($_POST["phone"]);

        try {
            Security::validatePassword($password);
        } catch (\Exception $e) {
            $this->data['message'] = $e->getMessage();
            return;
        }
        $isLog = $this->userConnectionService->registerUser($username, $email, $password, $firstName, $lastName, $phone);

        if ($isLog) {
            header("Location: /inscription_confirmee");
        } else {
            $this->data['message'] = "Erreur lors de l'inscription";
        }
    }
}
