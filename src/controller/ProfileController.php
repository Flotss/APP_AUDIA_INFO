<?php

namespace App\Controller;

use App\Service\UserService;
use App\Database\DataBaseSingleton;
use App\Utils\Security;


class ProfileController extends AbstractController
{

    private $userService;

    public function __construct()
    {
        parent::__construct("composant/profile");

        if ($_SERVER['REQUEST_URI'] === '/profile') {
            if (!$this->isConnected()) {
                header('Location: /connexion');
                exit();
            }

            $this->userService = new UserService();

            // POST request
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $this->updatePreferences();
                $this->updateUser();
            }

            // GET request
            $this->getPreferencesUser();
            $this->getAllPreferences();
            $this->user->setImage($this->userService->getImage($this->user->getEmail()));
            $this->addData('user', $this->user);
        }
    }

    private function getPreferencesUser()
    {
        $userService = $this->userService;
        $user = $userService->getUser($this->user->getEmail());
        $preferenceTemperature = $userService->getPreferenceTemperature($user->getEmail());
        $preferenceSon = $userService->getPreferenceSon($user->getEmail());

        $this->addData('preferences_temperature', $preferenceTemperature);
        $this->addData('preferences_acoustique', $preferenceSon);
    }

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

    private function updatePreferences()
    {
        $userService = $this->userService;
        $preferenceTemperature = $_POST['preference_temperature'];
        $preferenceSon = $_POST['preference_acoustique'];

        $userService->updatePreferenceTemperature($this->user, $preferenceTemperature);
        $userService->updatePreferenceSon($this->user, $preferenceSon);
    }

    private function updateUser()
    {
        $firstName = Security::sanitizeInput($_POST["firstName"]);
        $lastName = Security::sanitizeInput($_POST["lastName"]);
        $username = Security::sanitizeInput($_POST["username"]);
        $email = Security::sanitizeInput($_POST["email"]);
        $phone = Security::sanitizeInput($_POST["phone"]);
        $location = Security::sanitizeInput($_POST["location"]);
        $image = $_POST["imageBase64"];

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
    }
}