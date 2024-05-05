<?php

namespace App\Controller;

use App\Service\RetrieveDataFromDataUtils;

class CguAdminController extends AbstractAdminController
{

    public function __construct()
    {
        parent::__construct("cgu/admin");

        // POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cgu'])) {
            $this->updateCgu();
        }


        // Recuperer le contenu depuis la base de donnée
        $service = new RetrieveDataFromDataUtils();
        $this->data['cgu'] = $service->getContentByKey("cgu")->getValue();
    }

    private function updateCgu()
    {
        $service = new RetrieveDataFromDataUtils();
        $service->updateContentByKey("cgu", $_POST['cgu']);

        $this->data['cgu'] = $_POST['cgu'];
        $this->data['message'] = "CGU mis à jour";
    }
}