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

    use App\Controller\IndexController;

    $controller = new IndexController();
    $controller->index();
    ?>
</body>

</html>