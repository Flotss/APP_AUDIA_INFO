<?php

namespace App\Controller;

use App\Service\AdminVerificationService;

/**
 * The AbstractAminController class is responsible for handling requests related to the index page.
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
     *
     * @param mixed $id The ID of the item to show.
     */
    public function show($id)
    {
        $this->verifyAdmin();
        $this->tryCatch(function () use ($id) {
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
     *
     * @param mixed $id The ID of the item to update.
     */
    public function update($id)
    {
        $this->verifyAdmin();
        $this->tryCatch(function () use ($id) {
            // Logic for the update action
            $this->twig->display($this->pathToLoad . '/update.html.twig', $this->data);
        });
    }

    /**
     * Handles the delete action.
     *
     * @param mixed $id The ID of the item to delete.
     */
    public function delete($id)
    {
        $this->verifyAdmin();
        $this->tryCatch(function () use ($id) {
            // Logic for the delete action
            $this->twig->display($this->pathToLoad . '/delete.html.twig', $this->data);
        });
    }


    private function verifyAdmin()
    {
        $adminVerificationService = new AdminVerificationService();
        if (!$adminVerificationService->isAdmin()) {
            $this->redirect("/");
            exit();
        }

        $this->data["admin"] = true;
    }

    private function redirect($page)
    {
        if ($_SERVER['REQUEST_URI'] !== "/$page") {
            header("Location: /$page");
            exit();
        }
    }
}
