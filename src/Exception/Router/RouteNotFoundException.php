<?php

declare(strict_types=1);

namespace App\Exception\Router;

class RouteNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Route not found!");
    }
}
