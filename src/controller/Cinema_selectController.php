<?php

namespace App\Controller;

use App\Service\CinemaService;

/**
 * The ContactController class is responsible for handling requests related to the index page.
 */
class Cinema_selectController extends AbstractController
{

    /**
     * Constructs a new instance of the ContactController class.
     */
    public function __construct()
    {
        parent::__construct("Cinema_select");

        $service = new CinemaService();
        $cinemas = $service->getCinemas();
        $this->addData("cinemas", $cinemas);
    }
}
