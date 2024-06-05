<?php

namespace App\Controller\Admin;

use App\Service\UserService;
use App\Database\DataBaseSingleton;
use App\Utils\Security;

/**
 * Class GestionUtilisateursController
 * @package App\Controller\Admin
 */
class GestionUtilisateursController extends AbstractAdminController
{
    private UserService $userService;

    /**
     * GestionUtilisateursController constructor.
     */
    public function __construct()
    {
        parent::__construct("admin/gestion_utilisateurs");

        // if URI = '/admin/gestion_utilisateurs'
        if ($_SERVER['REQUEST_URI'] === '/admin/users') {
            $this->userService = new UserService();
            // if post 
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if ($_POST['action'] === 'update') {
                    // Get the form data
                    $this->updateUser();
                    $this->updatePreferences();

                    $this->addData('message', 'Utilisateur mis à jour');
                }

                if ($_POST['action'] === 'delete') {
                    $id = Security::sanitizeInput($_POST["id"]);
                    $this->userService->deleteUser($id);
                    $this->addData('message', 'Utilisateur supprimé');
                }
            }

            // Retrieve all users to display them
            $users = $this->userService->getAllUser();
            $this->addData('users', $users);

            // Preference temperature user => preference_temperature
            $arrayTemperature = [];
            foreach ($users as $user) {
                $arrayTemperature[$user["id"]] = $this->userService->getPreferenceTemperature($user['email']);
            }

            $this->addData('arrayTemperature', $arrayTemperature);

            // Preference acoustique user => preference_acoustique
            $arrayAcoustique = [];
            foreach ($users as $user) {
                $arrayAcoustique[$user["id"]] = $this->userService->getPreferenceSon($user['email']);
            }

            $this->addData('arrayAcoustique', $arrayAcoustique);

            // Preference all 
            $this->getAllPreferences();

            $this->getImageForUsers($users);
        }
    }

    /**
     * Get all preferences from temperatureType and sonType tables and add them to the data array.
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
     * Get the image for each user and add them to the data array.
     * @param array $users The array of users.
     */
    private function getImageForUsers($users)
    {
        $arrayImage = [];
        foreach ($users as $user) {
            $arrayImage[$user["id"]] = $this->userService->getImage($user['email']);
        }

        $this->addData('arrayImage', $arrayImage);
    }

    /**
     * Update the user's information based on the form data.
     */
    private function updateUser()
    {
        $id = Security::sanitizeInput($_POST["id"]);
        $firstName = Security::sanitizeInput($_POST["firstName"]);
        $lastName = Security::sanitizeInput($_POST["lastName"]);
        $username = Security::sanitizeInput($_POST["username"]);
        $email = Security::sanitizeInput($_POST["email"]);
        $phone = Security::sanitizeInput($_POST["phone"]);
        $location = Security::sanitizeInput($_POST["location"]);
        $image = $_POST["imageBase64"] ?? "";

        $userService = $this->userService;
        $user = $userService->getUserById($id);
        $user = $user->setFirstName($firstName);
        $user = $user->setLastName($lastName);
        $user = $user->setUsername($username);
        $user = $user->setEmail($email);
        $user = $user->setPhone($phone);
        $user = $user->setLocation($location);
        $user = $user->setImage($image);

        $userService->updateUser($user);
    }

    /**
     * Update the user's preferences based on the form data.
     */
    private function updatePreferences()
    {
        $userService = $this->userService;
        $preferenceTemperature = $_POST['preference_temperature'];
        $preferenceSon = $_POST['preference_acoustique'];

        $userService->updatePreferenceTemperature($this->user, $preferenceTemperature);
        $userService->updatePreferenceSon($this->user, $preferenceSon);
    }
}