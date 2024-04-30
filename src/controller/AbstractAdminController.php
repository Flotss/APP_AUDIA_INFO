<?php

namespace App\Controller;

use App\Service\AdminVerificationService;

/**
 * The AbstractAdminController class is responsible for handling requests related to the index page.
 */
abstract class AbstractAdminController extends AbstractController
{

    /**
     * Constructs a new instance of the AbstractAminController class.
     */
    public function __construct()
    {
        parent::__construct("index");
    }

    /**
     * Handles the index action.
     */
    public function index()
    {
        $this->verifyAdmin();
        $this->tryCatch(function () {
            // Logic for the index action
            $this->twig->display($this->pathToLoad . '/index.html.twig', $this->data);
        });
    }

    /**
     * Handles the show action.
     */
    public function show()
    {
        $this->verifyAdmin();
        $this->tryCatch(function () {
            // Logic for the show action
            $this->twig->display($this->pathToLoad . '/show.html.twig', $this->data);
        });
    }

    /**
     * Handles the create action.
     */
    public function create()
    {
        $this->verifyAdmin();
        $this->tryCatch(function () {
            // Logic for the create action
            $this->twig->display($this->pathToLoad . '/create.html.twig', $this->data);
        });
    }

    /**
     * Handles the update action.
     */
    public function update()
    {
        $this->verifyAdmin();
        $this->tryCatch(function () {
            // Logic for the update action
            $this->twig->display($this->pathToLoad . '/update.html.twig', $this->data);
        });
    }

    /**
     * Handles the delete action.
     */
    public function delete()
    {
        $this->verifyAdmin();
        $this->tryCatch(function () {
            // Logic for the delete action
            $this->twig->display($this->pathToLoad . '/delete.html.twig', $this->data);
        });
    }


    private function verifyAdmin()
    {
        $adminVerificationService = new AdminVerificationService();
        if (!$adminVerificationService->isAdmin()) {
            $this->redirect("");
            exit();
        }

        $this->data["admin"] = true;
    }

    private function redirect($page)
    {
        if ($page == '/') {
            $page = '';
        }

        if ($_SERVER['REQUEST_URI'] !== "/$page") {
            header("Location: /$page");
            die();
        }
    }
}