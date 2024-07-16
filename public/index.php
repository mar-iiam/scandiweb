<?php

require '../vendor/autoload.php';

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

$dispatcher = simpleDispatcher(function(RouteCollector $r) {
    $r->addRoute('POST', '/', ['App\controllers\ProductMagement', 'Add_product']);
    $r->addRoute('GET', '/get_products', ['App\controllers\ProductMagement', 'getProducts']);     
    $r->addRoute('DELETE', '/delete_product/{sku}', ['App\controllers\ProductMagement', 'delete_product']); // Corrected here
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo '404 Not Found';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        echo '405 Method Not Allowed';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        $class = $handler[0];
        $method = $handler[1];

        $controller = new $class();
        call_user_func_array([$controller, $method], $vars);
        break;
}
