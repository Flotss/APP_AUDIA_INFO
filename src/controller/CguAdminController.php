<?php

namespace App\Controller;

use App\Service\RetrieveDataFromDataUtils;

/**
 * The CguAdminController class is responsible for handling the CGU (Conditions Générales d'Utilisation) administration.
 */
class CguAdminController extends AbstractAdminController
{

    /**
     * Constructs a new CguAdminController object.
     */
    public function __construct()
    {
        parent::__construct("cgu/admin");

        // POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cgu'])) {
            $this->updateCgu();
        }

        // Retrieve the content from the database
        $service = new RetrieveDataFromDataUtils();

        try {
            $this->data['cgu'] = $service->getContentByKey("cgu")->getValue();
        } catch (\Exception $e) {
            $this->data['messageError'] = "Les informations du CGU ne sont pas disponibles";
        }
    }

    /**
     * Updates the CGU content in the database.
     */
    private function updateCgu()
    {
        $service = new RetrieveDataFromDataUtils();
        $service->updateContentByKey("cgu", $_POST['cgu']);

        $this->data['cgu'] = $_POST['cgu'];
        $this->data['message'] = "CGU ont été mis à jour";
    }
}
