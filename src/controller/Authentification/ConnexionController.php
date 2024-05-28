<?php

namespace App\Controller\Authentification;

use App\Service\UserConnectionService;
use App\Utils\Cookies;
use App\Utils\Security;
use App\Controller\AbstractController;
use App\Database\DataBaseSingleton;

/**
 * The ConnexionController class is responsible for handling requests related to the index page.
 */
class ConnexionController extends AbstractController
{

    private UserConnectionService $userConnectionService;
    private DataBaseSingleton $db;

    /**
     * Constructs a new instance of the ConnexionController class.
     */
    public function __construct()
    {
        parent::__construct("Authentification/Inscription");


        if ($_SERVER["REQUEST_URI"] === "/connexion") {
            $this->userConnectionService = new UserConnectionService();
            $this->db = DataBaseSingleton::getInstance();

            // IF CONNECTED REDIRECT TO HOME
            Cookies::exists("user") ? header("Location: /") : null;

            if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["actionLogin"])) {
                $this->handlePostRequest();
            }
        }
    }

    /**
     * Handles a POST request.
     */
    private function handlePostRequest()
    {
        if ($_POST["actionLogin"] === "login") {
            $this->handleConnection();
            return;
        }

        if ($_POST["actionLogin"] === "signup") {
            $this->handleInscription();
            return;
        }

        throw new \Exception("Invalid action.");
    }

    private function handleConnection()
    {
        $email = Security::sanitizeInput($_POST["email"]);
        $password = Security::sanitizeInput($_POST["password"]);

        $isLog = $this->userConnectionService->loginUser($email, $password);

        if ($isLog) {
            header("Location: /");
        } else {
            $this->data['messageError'] = "Email ou mot de passe incorrect";
        }
    }

    private function handleInscription()
    {
        $email = Security::sanitizeInput($_POST["email"]);
        $password = Security::sanitizeInput($_POST["password"]);
        $username = Security::sanitizeInput($_POST["username"]);
        $firstName = Security::sanitizeInput($_POST["first_name"]);
        $lastName = Security::sanitizeInput($_POST["last_name"]);

        try {
            Security::validatePassword($password);
        } catch (\Exception $e) {
            $this->data['messageError'] = $e->getMessage();
            return;
        }

        // Check if the email is already used
        $user = $this->db->getUserByEmail($email);
        if ($user) {
            $this->data['messageError'] = "Email déjà utilisé, veuillez en choisir un autre.";
            return;
        }

        $isLog = $this->userConnectionService->registerUser($username, $email, $password, $firstName, $lastName);

        if ($isLog) {
            header("Location: /inscription_confirmee");
        } else {
            $this->data['messageError'] = "Erreur lors de l'inscription";
        }
    }
}