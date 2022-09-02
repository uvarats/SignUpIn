<?php

use App\Annotation\Validator\Email;
use App\Annotation\Validator\Required;
use App\Controller\LoginController;
use App\Controller\MainController;
use App\Controller\RegisterController;
use App\Entity\User;
use App\Exception\Router\RouteNotFoundException;
use App\Router;
use App\Validator\UserValidator;
use DI\Container;
use Doctrine\Common\Annotations\AnnotationReader;
use Dotenv\Dotenv;

require '../vendor/autoload.php';

$dotenv = $dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

const VIEWS_PATH = '../templates';
$container = new Container();
$router = new Router($container);

$router->registerRoutes([
    ['/signin', 'GET', [LoginController::class, 'signinPage']],
    ['/signup', 'GET', [RegisterController::class, 'signupPage']],
    ['/signup/submit', 'POST', [RegisterController::class, 'formSubmit']],
    ['/', 'GET', [MainController::class, 'mainPage']]
]);


$path = $_SERVER['PATH_INFO'] ?? '/';

try {
    $router->resolve($path, $_SERVER['REQUEST_METHOD']);
} catch (RouteNotFoundException $exception) {
    echo $exception->getMessage();
}
