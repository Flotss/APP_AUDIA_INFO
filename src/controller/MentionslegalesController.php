<?php

namespace App\Controller;

use App\Entity\Content;
use App\Service\RetrieveDataFromDataUtils;

class MentionslegalesController extends AbstractController
{

    public function __construct()
    {
        parent::__construct("mentionslegales");

        // Recuperer le contenu depuis la base de donnée
        $service = new RetrieveDataFromDataUtils();

        try {
            $this->data['mentions_legales'] = $service->getContentByKey("mentions_legales")->getValue();
        } catch (\Exception $e) {
            $this->data['messageError'] = "Mentions légales non disponibles";
        }
    }
}