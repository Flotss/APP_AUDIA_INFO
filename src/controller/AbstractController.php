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
    }

    public function index()
    {
        $this->tryCatch(function () {
            // Logic for the index action
            $this->twig->load($this->pathToLoad . '/index.html.twig')->display($this->data);
        });
    }

    public function show($id)
    {
        $this->tryCatch(function () use ($id) {
            // Logic for the show action
            $this->twig->load($this->pathToLoad . '/show.html.twig')->display(['id' => $id]);
        });
    }

    public function create()
    {
        $this->tryCatch(function () {
            // Logic for the create action
            echo $this->twig->load($this->pathToLoad . '/create.html.twig')->render([]);
        });
    }

    public function update($id)
    {
        $this->tryCatch(function () use ($id) {
            // Logic for the update action
            echo $this->twig->load($this->pathToLoad . '/update.html.twig')->render(['id' => $id]);
        });
    }

    public function delete($id)
    {
        $this->tryCatch(function () use ($id) {
            // Logic for the delete action
            echo $this->twig->load($this->pathToLoad . '/delete.html.twig')->render(['id' => $id]);
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