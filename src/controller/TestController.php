<?php

namespace App\Controller;

/**
 * The IndexController class is responsible for handling requests related to the index page.
 */
class TestController extends AbstractAdminController
{

    /**
     * Constructs a new instance of the IndexController class.
     */
    public function __construct()
    {
        parent::__construct("index");
    }
}
