<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event IT</title>
</head>

<body>
    <?php
    require_once 'vendor/autoload.php';

    use App\Router\Router;
    use App\Controller\IndexController;


    // TODO : MAKE DYNAMIC HEADER 
    // HEADER IS NOT SAME IF WE ARE IN ADMIN PAGE OR USER PAGE


    if (!isset($_GET['url'])) {
        $_GET['url'] = '/';
    }
    $router = new Router($_GET['url']);

    // AJOUTER UN GET COMME ICI POUR CHAQUE PAGE
    // Avec le controller associé à votre page
    $router->get('/', function () {
        $controller = new IndexController();
        $controller->index();
    });
    $router->run();


    // TODO : CREATE FOOTER
    // AND RUN IT HERE


    ?>
</body>

</html>