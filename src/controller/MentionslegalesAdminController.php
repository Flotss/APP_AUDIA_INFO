<?php

namespace App\Controller;

use App\Service\RetrieveDataFromDataUtils;

class MentionslegalesAdminController extends AbstractAdminController
{

    public function __construct()
    {
        parent::__construct("mentionslegales/admin");

        // POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mentionslegales'])) {
            $this->updateCgu();
        }


        // Recuperer le contenu depuis la base de donnée
        $service = new RetrieveDataFromDataUtils();
        $this->data['mentionslegales'] = $service->getContentByKey("mentions_legales")->getValue();
    }

    private function updateCgu()
    {
        $service = new RetrieveDataFromDataUtils();
        $service->updateContentByKey("mentions_legales", $_POST['mentionslegales']);

        $this->data['mentionslegales'] = $_POST['mentions_legales'];
        $this->data['message'] = " Mentions Légales ont été mis à jour";
    }
}
