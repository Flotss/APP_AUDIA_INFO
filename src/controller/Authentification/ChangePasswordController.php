<?php

namespace App\Controller\Authentification;

use App\Service\UserConnectionService;
use App\Utils\Cookies;
use App\Utils\Security;
use App\Controller\AbstractController;
use App\Database\DataBaseSingleton;

/**
 * The ChangePasswordController class is responsible for handling requests related to the index page.
 */
class ChangePasswordController extends AbstractController
{

    private UserConnectionService $userConnectionService;
    private DataBaseSingleton $db;

    /**
     * Constructs a new instance of the ChangePasswordController class.
     */
    public function __construct()
    {
        parent::__construct("Authentification/changement_mot_de_passe");

        $REQUEST_URI = explode("?", $_SERVER["REQUEST_URI"])[0];
        if ($REQUEST_URI === "/change_password") {
            $this->userConnectionService = new UserConnectionService();
            $this->db = DataBaseSingleton::getInstance();

            // IF CONNECTED REDIRECT TO HOME
            Cookies::exists("user") ? header("Location: /") : null;

            if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["token"])) {
                $this->handleGetRequest();
            } else if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["token"])) {
                $this->handlePostRequest();
            } else {
                $this->data['messageError'] = "Aucun token fourni. Vous allez être redirigé vers la page de connexion.";

                // wait 5 seconds before redirecting
                header("refresh:5;url=/connexion");
            }
        }
    }

    /**
     * Handles a POST request.
     */
    private function handleGetRequest()
    {
        $token = Security::sanitizeInput($_GET["token"]);
        $user = $this->db->getUserByToken($token);

        if ($user) {
            $this->data['token'] = $token;
        } else {
            $this->data['messageError'] = "Token invalide ou expiré. Vous allez être redirigé vers la page de connexion.";

            // wait 5 seconds before redirecting
            header("refresh:3;url=/");
        }
    }

    /**
     * Handles a POST request.
     */
    private function handlePostRequest()
    {
        $token = Security::sanitizeInput($_POST["token"]);
        $password = Security::sanitizeInput($_POST["new_password"]);
        $passwordConfirm = Security::sanitizeInput($_POST["confirm_password"]);

        if ($password === $passwordConfirm) {
            $user = $this->db->getUserByToken($token);

            if ($user) {
                $this->userConnectionService->updateUserPassword($user, Security::hashPassword($password));
                $this->data['message'] = "Mot de passe modifié avec succès. Vous allez être redirigé vers la page de connexion.";

                // wait 5 seconds before redirecting
                header("refresh:5;url=/connexion");
            } else {
                $this->data['messageError'] = "Token invalide ou expiré. Vous allez être redirigé vers la page de connexion.";

                // wait 5 seconds before redirecting
                header("refresh:5;url=/connexion");
            }
        } else {
            $this->data['messageError'] = "Les mots de passe ne correspondent pas.";
        }
    }
}
