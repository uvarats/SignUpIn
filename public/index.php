<?php

use App\Controller\LoginController;
use App\Controller\MainController;
use App\Controller\RegisterController;
use App\Exception\Router\RouteNotFoundException;
use App\Router;
use Composer\Autoload\ClassLoader;
use DI\Container;
use Dotenv\Dotenv;

require '../vendor/autoload.php';

$dotenv = $dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenvLocal = Dotenv::createImmutable(dirname(__DIR__), '.env.local');
var_dump($dotenvLocal);

const VIEWS_PATH = '../templates';
$container = new Container();
$router = new Router($container);

$router->registerRoutes([
    ['/signin', 'GET', [LoginController::class, 'signinPage']],
    ['/signup', 'GET', [RegisterController::class, 'signupPage']],
    ['/', 'GET', [MainController::class, 'mainPage']]
]);


$path = $_SERVER['PATH_INFO'] ?? '/';

try {
    $router->resolve($path, $_SERVER['REQUEST_METHOD']);
}
catch (RouteNotFoundException $exception) {
    echo $exception->getMessage();
}