<?php
require_once 'vendor/autoload.php';
require_once 'src/Config/Credentials.php';

use App\Router\Router;
use App\Controller\IndexController;
use App\Exceptions\RouterException;
use App\Controller\ContactController;
use App\Controller\MonitoringController;


if (!isset($_GET['url'])) {
    $_GET['url'] = '/';
}
$router = new Router($_GET['url']);

// AJOUTER LA ROUTE COMME ICI POUR CHAQUE PAGE
// Avec le controller associé à votre page
$routes = [
    '/' => new IndexController(),
    '/contact' => new ContactController(),
    '/monitoring' => new MonitoringController(),
    // Add more routes here
];

foreach ($routes as $route => $controller) {
    $router->get($route, function () use ($controller) {
        $controller->index();
    });
}

try {
    $router->run();
} catch (RouterException $e) {
    // TODO : CREATE ERROR PAGE
    // EN CAS D'ERREUR 404
    // TODO : FAIRE UNE PAGE D'ERREUR

    // EN CAS d'autre erreur
    // TODO : FAIRE UNE PAGE D'ERREUR GENERIQUE


    // Pour l'instant on redirige vers la page d'accueil
    $controller = new IndexController();
    $controller->index();
}
