<?php

require '../vendor/autoload.php';

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;
 
header('Access-Control-Allow-Origin: *'); // Or specify your frontend origin
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS'); 
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204); // No content
    exit();
}

$dispatcher = simpleDispatcher(function(RouteCollector $r) {
    $r->addRoute('POST', '/', ['App\controllers\ProductManagement', 'addProduct']);
    $r->addRoute('GET', '/get_products', ['App\controllers\ProductManagement', 'getProducts']);     
    $r->addRoute('DELETE', '/delete_product', ['App\controllers\ProductManagement', 'deleteProduct']); // Corrected here
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
        echo json_encode(["status" => "error", "message" => "404 Not Found"]);
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        echo json_encode(["status" => "error", "message" => "405 Method Not Allowed"]);
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
