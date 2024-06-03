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
     *
     * @param string $templatePath The path to the template directory.
     */
    public function __construct(string $templatePath = 'template/admin')
    {
        parent::__construct($templatePath);
        $this->addData('admin_page', true);
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

    /**
     * Verifies if the user is an admin.
     * If the user is not an admin, it redirects to the homepage and exits the script.
     */
    private function verifyAdmin()
    {
        $adminVerificationService = new AdminVerificationService();
        if (!$adminVerificationService->isAdmin()) {
            $this->redirect("");
            exit();
        }

        $this->data["admin"] = true;
    }

    /**
     * Redirects the user to the specified page.
     *
     * @param string $page The page to redirect to.
     */
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