<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HELLO WORLD</title>
</head>

<body>
    <?php
    require_once 'vendor/autoload.php';

    use App\Router\Router;
    use App\Router\Route;
    use App\Controller\IndexController;


    // TODO : MAKE DYNAMIC HEADER 
    // HEADER IS NOT SAME IF WE ARE IN ADMIN PAGE OR USER PAGE


    $router = new Router($_GET['url']);
    echo $router->url;
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