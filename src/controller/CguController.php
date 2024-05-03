<?php

namespace App\Controller;

use App\Service\RetrieveDataFromDataUtils;

class CguController extends AbstractController
{

    public function __construct()
    {
        parent::__construct("cgu");


        // Recuperer le contenu depuis la base de donnée
        $service = new RetrieveDataFromDataUtils();
        $this->data['cgu'] = $service->getContentByKey("cgu")->getValue();
    }
}