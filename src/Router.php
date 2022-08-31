<?php

namespace App;

use App\Exception\Router\RouteNotFoundException;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;

class Router
{
    private array $routes = [];
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function registerRoute(string $route, string $method, $action): self
    {
        $this->routes[$method][$route] = $action;

        return $this;
    }

    public function registerRoutes(array $routes) {
        foreach ($routes as $route) {
            $this->registerRoute($route[0], $route[1], $route[2]);
        }
    }

    /**
     * @param string $requestPath
     * @param string $requestMethod
     * @return mixed
     * @throws RouteNotFoundException
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function resolve(string $requestPath, string $requestMethod) {
        $action = $this->routes[$requestMethod][$requestPath] ?? null;

        if(!$action) {
            throw new RouteNotFoundException();
        }

        if(is_callable($action)) {
            $this->container->call($action);
        }

        [$class, $method] = $action;

        if(class_exists($class)) {
            $class = $this->container->get($class);
            if(method_exists($class, $method)) {
                return call_user_func_array([$class, $method], []);
            }
        }
        throw new RouteNotFoundException();
    }
}