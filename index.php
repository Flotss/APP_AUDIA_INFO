<?php
require_once 'vendor/autoload.php';
require_once 'src/Config/Credentials.php';

use App\Router\Router;
use App\Controller\IndexController;
use App\Controller\Authentification\ConnexionController;
use App\Controller\Authentification\ChangePasswordController;
use App\Controller\Authentification\PasswordForgotController;
use App\Controller\ProfileController;
use App\Controller\FaqController;
use App\Exceptions\RouterException;
use App\Controller\ContactController;
use App\Controller\MonitoringController;
use App\Controller\CguController;
use App\Controller\MentionslegalesController;
use App\Controller\Cinema_selectController;

use App\Controller\DeconnexionController;

//ADMIN
use App\Controller\FaqAdminController;
use App\Controller\CguAdminController;
use App\Controller\MentionslegalesAdminController;
use App\Controller\Admin\GestionUtilisateursController;

//API
use App\Controller\ApiController\MonitoringApiController;

session_start();


if (!isset($_GET['url'])) {
    $_GET['url'] = '/';
}
$router = new Router($_GET['url']);


$ProfileController = new ProfileController();


$routesGet = [
    '/' => new IndexController(),
    '/faq' => new FaqController(),
    '/contact' => new ContactController(),
    '/monitoring' => new MonitoringController(),

    '/connexion' => new ConnexionController(),
    '/forgot_password' => new PasswordForgotController(),
    '/change_password' => new ChangePasswordController(),
    '/profile' => $ProfileController,
    '/profile/password' => $ProfileController,

    '/cgu' => new CguController(),
    '/mentionslegales' => new MentionslegalesController(),
    '/cinema_select' => new Cinema_selectController(),
    '/deconnexion' => new DeconnexionController(),

    // ADMIN ROUTES
    '/admin/faq' => new FaqAdminController(),
    '/admin/cgu' => new CguAdminController(),
    '/admin/mentionslegales' => new MentionslegalesAdminController(),
    '/admin/users' => new GestionUtilisateursController(),

];

$routePost = [
    '/connexion' => $routesGet['/connexion'],
    '/profile' => $routesGet['/profile'],
    '/profile/password' => $routesGet['/profile/password'],

    '/forgot_password' => $routesGet['/forgot_password'],
    '/change_password' => $routesGet['/change_password'],

    '/admin/cgu' => $routesGet['/admin/cgu'],
    '/admin/faq' => $routesGet['/admin/faq'],
    '/admin/users' => $routesGet['/admin/users'],
    '/admin/mentionslegales' => $routesGet['/admin/mentionslegales'],
];


$routeApiGet = [
    '/api/monitoring' => new MonitoringApiController(),
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

// IF backoffice redirection
// IF LOCATION IS /backoffice
// REDIRECT TO /admin/faq
if ($_GET['url'] === 'backoffice') {
    header('Location: /admin/faq');
    exit();
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

    echo $e->getMessage();
}
