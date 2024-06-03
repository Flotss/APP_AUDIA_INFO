<?php

namespace App\Controller;

use App\Service\UserService;
use App\Database\DataBaseSingleton;
use App\Utils\Security;
use App\Utils\Cookies;


class ProfileController extends AbstractController
{

    private $userService;

    /**
     * Constructs a new instance of the ProfileController class.
     */
    public function __construct()
    {
        parent::__construct("profile");
        $this->userService = new UserService();

        if ($_SERVER['REQUEST_URI'] === '/profile') {
            // IF NOT CONNECTED REDIRECT TO LOGIN
            if (!$this->isConnected()) {
                header('Location: /connexion');
                exit();
            }


            // POST request
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $this->updatePreferences();
                $this->updateUser();

                $this->data['message'] = 'Profil mis à jour';
            }

            // GET request
            $this->handleGetRequest();
        }

        if ($_SERVER['REQUEST_URI'] === '/profile/password') {
            // POST request
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $this->updatePassword();
            }

            // GET request
            $this->handleGetRequest();
        }
    }

    /**
     * Handles a GET request.
     * This method is responsible for checking if the user is connected and getting the user's data.
     */
    private function handleGetRequest()
    {
        // Get user data
        $this->getPreferencesUser();
        $this->getAllPreferences();

        // Get user data
        $this->user = $this->userService->getUser($this->user->getEmail());
        $this->user->setImage($this->userService->getImage($this->user->getEmail()));
        $this->addData('user', $this->user);
    }

    /**
     * Gets the user's preferences.
     * This method is responsible for getting the user's preferences from the database.
     */
    private function getPreferencesUser()
    {
        $userService = $this->userService;
        $user = $userService->getUser($this->user->getEmail());
        $preferenceTemperature = $userService->getPreferenceTemperature($user->getEmail());
        $preferenceSon = $userService->getPreferenceSon($user->getEmail());

        $this->addData('preferences_temperature', $preferenceTemperature);
        $this->addData('preferences_acoustique', $preferenceSon);
    }

    /**
     * Gets all preferences from the temperatureType and acousticsType tables.
     * This method is responsible for getting all preferences from the temperatureType and acousticsType tables.
     */
    private function getAllPreferences()
    {
        $db = DataBaseSingleton::getInstance();
        // make request to get all preferences from temperatureType (id, name, created_at, updated_at)
        $resTemperature = $db->makeRequest('SELECT name FROM temperatureType');
        // make request to get all preferences from sonType (id, name, created_at, updated_at)
        $resSon = $db->makeRequest('SELECT name FROM acousticsType');

        $this->addData('preferences_temperature_options', $resTemperature);
        $this->addData('preferences_acoustique_options', $resSon);
    }

    /**
     * Updates the user's preferences.
     * This method is responsible for updating the user's preferences in the database.
     */
    private function updatePreferences()
    {
        $userService = $this->userService;
        $preferenceTemperature = $_POST['preference_temperature'];
        $preferenceSon = $_POST['preference_acoustique'];

        $userService->updatePreferenceTemperature($this->user, $preferenceTemperature);
        $userService->updatePreferenceSon($this->user, $preferenceSon);
    }

    /**
     * Updates the user's data.
     * This method is responsible for updating the user's data in the database.
     */
    private function updateUser()
    {
        // Sanitize input
        $firstName = Security::sanitizeInput($_POST["firstName"]);
        $lastName = Security::sanitizeInput($_POST["lastName"]);
        $username = Security::sanitizeInput($_POST["username"]);
        $email = Security::sanitizeInput($_POST["email"]);
        $phone = Security::sanitizeInput($_POST["phone"]);
        $location = Security::sanitizeInput($_POST["location"]);
        $image = $_POST["imageBase64"] ?? "";

        // Update user
        $userService = $this->userService;
        $user = $userService->getUser($this->user->getEmail());

        $user = $user->setFirstName($firstName);
        $user = $user->setLastName($lastName);
        $user = $user->setUsername($username);
        $user = $user->setEmail($email);
        $user = $user->setPhone($phone);
        $user = $user->setLocation($location);
        $user = $user->setImage($image);

        $userService->updateUser($user);

        // Update user in cookies
        Cookies::set('user', serialize($user));
    }

    /**
     * Updates the user's password.
     * This method is responsible for updating the user's password in the database.
     */
    private function updatePassword()
    {
        // Sanitize input
        $oldPassword = Security::sanitizeInput($_POST["currentPassword"]);
        $newPassword = Security::sanitizeInput($_POST["newPassword"]);
        $confirmPassword = Security::sanitizeInput($_POST["confirmPassword"]);

        // Check if new password and confirm password match
        if ($newPassword !== $confirmPassword) {
            $this->addData('messageError', 'Les mots de passe ne correspondent pas');
            return;
        }

        // Get user from database
        $userService = $this->userService;
        $user = $userService->getUser($this->user->getEmail());


        // Check if old password is correct
        if (!password_verify($oldPassword, $user->getPassword())) {
            $this->addData('messageError', 'Ancien mot de passe incorrect');
            return;
        }

        // Update password
        $user = $user->setPasswordHashed($newPassword);
        $userService->updateUser($user);
        $this->addData('message', 'Mot de passe mis à jour');
    }
}
