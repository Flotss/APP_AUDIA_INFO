<?php

namespace App\Controller;

/**
 * The ContactController class is responsible for handling requests related to the index page.
 */
class ContactController extends AbstractController
{

    /**
     * Constructs a new instance of the ContactController class.
     */
    public function __construct()
    {
        parent::__construct("Contact");
    }
}
