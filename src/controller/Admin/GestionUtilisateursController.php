<?php

namespace App\Controller\Admin;

use App\Controller\AbstractAdminController;
use App\Service\UserService;
use App\Database\DataBaseSingleton;

class GestionUtilisateursController extends AbstractAdminController
{
    private UserService $userService;

    public function __construct()
    {
        parent::__construct("admin/gestion_utilisateurs");

        // if URI = '/admin/gestion_utilisateurs'
        if ($_SERVER['REQUEST_URI'] === '/admin/users') {
            $this->userService = new UserService();

            // Retreive all users to display them
            $users = $this->userService->getAllUser();
            $this->addData('users', $users);

            // Preference temperature user => preference_temperature
            $arrayTemperature = [];
            foreach ($users as $user) {
                $arrayTemperature[$user["id"]] = $this->userService->getPreferenceTemperature($user['email']);
            }
            var_dump($arrayTemperature);

            $this->addData('arrayTemperature', $arrayTemperature);

            // Preference acoustique user => preference_acoustique
            $arrayAcoustique = [];
            foreach ($users as $user) {
                $arrayAcoustique[$user["id"]] = $this->userService->getPreferenceSon($user['email']);
            }

            $this->addData('arrayAcoustique', $arrayAcoustique);

            // Preference all 
            $this->getAllPreferences();
        }
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
