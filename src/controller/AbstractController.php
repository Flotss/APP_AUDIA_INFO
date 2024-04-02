<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractController
{
    protected $twig;
    protected $twigError;
    protected $data = [];


    public function __construct(string $templatePath = 'template/example')
    {
        $loader = new FilesystemLoader($templatePath);
        $this->twig = new Environment($loader);

        $this->twigError = new Environment(new FilesystemLoader('template/error'));
    }

    public function index()
    {
        $this->tryCatch(function () {
            // Logic for the index action
            echo $this->twig->render('index.html.twig', ['data' => $this->data]);
        });
    }

    public function show($id)
    {
        $this->tryCatch(function () use ($id) {
            // Logic for the show action
            echo $this->twig->render('show.html.twig', ['id' => $id]);
        });
    }

    public function create()
    {
        $this->tryCatch(function () {
            // Logic for the create action
            echo $this->twig->render('create.html.twig');
        });
    }

    public function update($id)
    {
        $this->tryCatch(function () use ($id) {
            // Logic for the update action
            echo $this->twig->render('update.html.twig', ['id' => $id]);
        });
    }

    public function delete($id)
    {
        $this->tryCatch(function () use ($id) {
            // Logic for the delete action
            echo $this->twig->render('delete.html.twig', ['id' => $id]);
        });
    }

    private function tryCatch(callable $callback)
    {
        try {
            $callback();
        } catch (\Exception $e) {
            echo $this->twigError->render('error.html.twig', ['error' => $e->getMessage()]);
        }
    }
}
