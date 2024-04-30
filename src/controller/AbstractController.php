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
            $this->twig->display($this->pathToLoad . '/index.html.twig', $this->data);
        });
    }

    /**
     * Handles the show action.
     */
    public function show()
    {
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
    public function update()
    {
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
        $this->tryCatch(function () {
            // Logic for the delete action
            $this->twig->display($this->pathToLoad . '/delete.html.twig', $this->data);
        });
    }

    /**
     * Executes a callback function within a try-catch block.
     *
     * @param callable $callback The callback function to execute.
     */
    protected function tryCatch(callable $callback)
    {
        // try {
        $callback();
        // } catch (\Exception $e) {
        // echo $this->twigError->render('error.html.twig', ['error' => $e->getMessage()]);
        // }
    }
}