<?php

namespace App\Controller;

use App\Service\UserService;
use App\Database\DataBaseSingleton;


class ProfileController extends AbstractController
{

    public function __construct()
    {
        parent::__construct("composant/profile");



        // if url = /profile
        if ($_SERVER['REQUEST_URI'] === '/profile') {
            if (!$this->isConnected()) {
                header('Location: /connexion');
                exit();
            }

            $this->getPreferencesUser();
            $this->getAllPreferences();
        }
    }

    private function getPreferencesUser()
    {
        $userService = new UserService();

        $user = $userService->getUser($this->user->getEmail());
        $this->data['user'] = $user;
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
}
