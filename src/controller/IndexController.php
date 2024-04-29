<?php

namespace App\Controller;

/**
 * The IndexController class is responsible for handling requests related to the index page.
 */
class IndexController extends AbstractController
{

    /**
     * Constructs a new instance of the IndexController class.
     */
    public function __construct()
    {
        parent::__construct("index");
    }
}
