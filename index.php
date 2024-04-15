<?php
require_once 'vendor/autoload.php';
require_once 'src/Config/Credentials.php';

use App\Router\Router;
use App\Controller\IndexController;
use App\Controller\ConnexionController;
use App\Controller\FaqController;
use App\Controller\FaqAdminController;
use App\Exceptions\RouterException;
use App\Controller\ContactController;
use App\Controller\MonitoringController;
use App\Controller\CguController;
use App\Controller\MentionslegalesController;

//ADMIN
use App\Controller\CguAdminController;




if (!isset($_GET['url'])) {
    $_GET['url'] = '/';
}
$router = new Router($_GET['url']);

// AJOUTER LA ROUTE COMME ICI POUR CHAQUE PAGE
// Avec le controller associé à votre page
$routesGet = [
    '/' => new IndexController(),
    '/faq' => new FaqController(),
    '/admin/faq' => new FaqAdminController(),
    '/contact' => new ContactController(),
    '/monitoring' => new MonitoringController(),
    '/connexion' => new ConnexionController(),
    '/cgu' => new CguController(),
    '/mentionslegales' => new MentionslegalesController(),

    // ADMIN ROUTES
    '/admin/cgu' => new CguAdminController(),
];

$routePost = [
    '/connexion' => new ConnexionController(),
    '/admin/cgu' => new CguAdminController(),
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