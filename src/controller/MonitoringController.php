<?php

namespace App\Controller;

use App\Database\DataBaseSingleton;

/**
 * The MonitoringController class is responsible for handling requests related to the index page.
 */
class MonitoringController extends AbstractController
{

    /**
     * Constructs a new instance of the MonitoringController class.
     */
    public function __construct()
    {
        parent::__construct("Monitoring");

        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            return ['error' => 'Invalid id'];
        }

        $id = $_GET['id'];

        // reprendre les données comme le nom de la salle etc.. depuis la base cinéma
        // voir quel cinema est selectionner recuperer l'id du cinema

        $this->data['cinema'] = $this->getCinema($id);
    }

    private function getCinema($id)
    {
        $db = DataBaseSingleton::getInstance();
        $cinema = $db->makeRequest("SELECT * FROM Cinema WHERE id = :id", [':id' => $id]);
        return $cinema[0];
    }
}
