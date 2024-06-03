<?php

namespace App\Controller;

use App\Service\RetrieveDataFromDataUtils;

/**
 * The MentionslegalesController class is responsible for handling requests related to the mentions légales page.
 */
class MentionslegalesController extends AbstractController
{

    /**
     * Constructs a new instance of the MentionslegalesController class.
     * Initializes the parent class and retrieves the content from the data utils service.
     */
    public function __construct()
    {
        parent::__construct("mentionslegales");

        // Retrieve the content from the data utils service
        $service = new RetrieveDataFromDataUtils();

        try {
            $this->data['mentions_legales'] = $service->getContentByKey("mentions_legales")->getValue();
        } catch (\Exception $e) {
            $this->data['messageError'] = "Mentions légales non disponibles";
        }
    }
}
