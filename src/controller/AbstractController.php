<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractController
{
    protected $twig;
    protected $pathToLoad;
    protected $twigError;
    protected $data = [];


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

    public function addData($key, $value)
    {
        $this->data[$key] = $value;
    }


    public function index()

    {
        $this->tryCatch(function () {
            // Logic for the index action
            $this->twig->display($this->pathToLoad . '/index.html.twig', $this->data);
        });
    }

    public function show($id)
    {
        $this->tryCatch(function () use ($id) {
            // Logic for the show action
            $this->twig->display($this->pathToLoad . '/show.html.twig', $this->data);
        });
    }

    public function create()
    {
        $this->tryCatch(function () {
            // Logic for the create action
            $this->twig->display($this->pathToLoad . '/create.html.twig', $this->data);
        });
    }

    public function update($id)
    {
        $this->tryCatch(function () use ($id) {
            // Logic for the update action
            $this->twig->display($this->pathToLoad . '/update.html.twig', $this->data);
        });
    }

    public function delete($id)
    {
        $this->tryCatch(function () use ($id) {
            // Logic for the delete action
            $this->twig->display($this->pathToLoad . '/delete.html.twig', $this->data);
        });
    }

    private function tryCatch(callable $callback)
    {
        // try {
        $callback();
        // } catch (\Exception $e) {
        // echo $this->twigError->render('error.html.twig', ['error' => $e->getMessage()]);
        // }
    }
}