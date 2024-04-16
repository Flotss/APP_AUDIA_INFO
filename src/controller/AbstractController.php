<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * The AbstractController class provides a base class for other controllers in the application.
 */
abstract class AbstractController
{
    protected $twig;
    protected $pathToLoad;
    protected $twigError;
    protected $data = [];

    /**
     * Constructs a new AbstractController instance.
     *
     * @param string $templatePath The path to the template directory.
     */
    public function __construct(string $templatePath = 'template')
    {
        $loader = new FilesystemLoader('template');
        $this->twig = new Environment($loader);
        $this->pathToLoad = $templatePath;

        $this->twigError = new Environment(new FilesystemLoader('template/error'));

        // TODO : Execute service to retrieve data
        // Like a service to retrieve User data (isAdmin, isLogged, etc)
        // Or a service to retrieve data from internet etc...
    }

    /**
     * Adds data to the controller's data array.
     *
     * @param mixed $key   The key to associate with the data.
     * @param mixed $value The value to add.
     */
    public function addData($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Handles the index action.
     */
    public function index()
    {
        $this->tryCatch(function () {
            // Logic for the index action
            $this->twig->load($this->pathToLoad . '/index.html.twig')->display($this->data);
        });
    }

    /**
     * Handles the show action.
     *
     * @param mixed $id The ID of the item to show.
     */
    public function show($id)
    {
        $this->tryCatch(function () use ($id) {
            // Logic for the show action
            $this->twig->load($this->pathToLoad . '/show.html.twig')->display(['id' => $id]);
        });
    }

    /**
     * Handles the create action.
     */
    public function create()
    {
        $this->tryCatch(function () {
            // Logic for the create action
            echo $this->twig->load($this->pathToLoad . '/create.html.twig')->render([]);
        });
    }

    /**
     * Handles the update action.
     *
     * @param mixed $id The ID of the item to update.
     */
    public function update($id)
    {
        $this->tryCatch(function () use ($id) {
            // Logic for the update action
            echo $this->twig->load($this->pathToLoad . '/update.html.twig')->render(['id' => $id]);
        });
    }

    /**
     * Handles the delete action.
     *
     * @param mixed $id The ID of the item to delete.
     */
    public function delete($id)
    {
        $this->tryCatch(function () use ($id) {
            // Logic for the delete action
            echo $this->twig->load($this->pathToLoad . '/delete.html.twig')->render(['id' => $id]);
        });
    }

    /**
     * Executes a callback function within a try-catch block.
     *
     * @param callable $callback The callback function to execute.
     */
    private function tryCatch(callable $callback)
    {
        // try {
        $callback();
        // } catch (\Exception $e) {
        // echo $this->twigError->render('error.html.twig', ['error' => $e->getMessage()]);
        // }
    }
}