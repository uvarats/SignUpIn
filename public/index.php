<?php

use App\Annotation\Validator\Email;
use App\Annotation\Validator\Required;
use App\Controller\LoginController;
use App\Controller\MainController;
use App\Controller\RegisterController;
use App\Crud\UserCrud;
use App\Entity\User;
use App\Exception\Router\RouteNotFoundException;
use App\Json;
use App\Router;
use App\Service\PasswordService;
use App\Service\UserService;
use App\Validator\UserValidator;
use Cerbero\JsonObjects\JsonObjects;
use DI\Container;
use Doctrine\Common\Annotations\AnnotationReader;
use Dotenv\Dotenv;

require '../vendor/autoload.php';

session_start();

$dotenv = $dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

const VIEWS_PATH = '../templates';
$container = new Container();
$router = new Router($container);

$router->registerRoutes([
    ['/signin', 'GET', [LoginController::class, 'signinPage']],
    ['/signin/submit', 'POST', [LoginController::class, 'formSubmit']],
    ['/signup', 'GET', [RegisterController::class, 'signupPage']],
    ['/signup/submit', 'POST', [RegisterController::class, 'formSubmit']],
    ['/logout', 'GET', [LoginController::class, 'logout']],
    ['/', 'GET', [MainController::class, 'mainPage']]
]);


$path = $_SERVER['PATH_INFO'] ?? '/';

if (!file_exists($_ENV['USERS_FILE'])) {
    file_put_contents($_ENV['USERS_FILE'], Json::encode([
        'last_id' => 0,
        'users' => [],
    ]));
}

try {
    $router->resolve($path, $_SERVER['REQUEST_METHOD']);
} catch (RouteNotFoundException $exception) {
    header("HTTP/1.1 404 Not Found");
}
