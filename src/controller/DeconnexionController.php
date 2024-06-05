<?php

namespace App\Controller;

/**
 * The DeconnexionController class is responsible for handling requests related to the index page.
 */
class DeconnexionController extends AbstractController
{

    /**
     * Constructs a new instance of the DeconnexionController class.
     */
    public function __construct()
    {
        parent::__construct("index");

        // IF CONNECTED REDIRECT TO HOME
        if (isset($_COOKIE['user']) && $_SERVER["REQUEST_URI"] === "/deconnexion") {
            // Delete the cookie
            setcookie('user', '', time() - 3600, '/');
            unset($_COOKIE['user']);

            // Redirect to home
            header('Location: /');
        }
    }
}
