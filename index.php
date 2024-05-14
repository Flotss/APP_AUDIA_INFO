<?php
require_once 'vendor/autoload.php';
require_once 'src/Config/Credentials.php';

use App\Router\Router;
use App\Controller\IndexController;
use App\Controller\ConnexionController;
use App\Controller\FaqController;
use App\Exceptions\RouterException;
use App\Controller\ContactController;
use App\Controller\MonitoringController;
use App\Controller\CguController;
use App\Controller\MentionslegalesController;

//ADMIN
use App\Controller\FaqAdminController;
use App\Controller\CguAdminController;

//API
use App\ApiController\MonitoringApiController;





if (!isset($_GET['url'])) {
    $_GET['url'] = '/';
}
$router = new Router($_GET['url']);

// AJOUTER LA ROUTE COMME ICI POUR CHAQUE PAGE
// Avec le controller associé à votre page
$routesGet = [
    '/' => new IndexController(),
    '/faq' => new FaqController(),
    '/contact' => new ContactController(),
    '/monitoring' => new MonitoringController(),
    '/connexion' => new ConnexionController(),
    '/cgu' => new CguController(),
    '/mentionslegales' => new MentionslegalesController(),

    // ADMIN ROUTES
    '/admin/faq' => new FaqAdminController(),
    '/admin/cgu' => new CguAdminController(),
];

$routePost = [
    '/connexion' => $routesGet['/connexion'],
    '/admin/cgu' => $routesGet['/admin/cgu'],
    '/admin/faq' => $routesGet['/admin/faq'],
];


$routeApiGet = [
    '/api/monitoring' => new MonitoringApiController(),
];

foreach ($routesGet as $route => $controller) {
    $router->get($route, function () use ($controller) {
        $controller->index();
    });
}

foreach ($routePost as $route => $controller) {
    $router->post($route, function () use ($controller) {
        $controller->index();
    });
}

foreach ($routeApiGet as $route => $controller) {
    $router->get($route, function () use ($controller) {
        $controller->get();
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
