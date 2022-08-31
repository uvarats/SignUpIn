<?php

namespace App\Controller;

use App\View;

class MainController
{
    public function __construct()
    {
    }

    public function mainPage() {
        echo View::getTwig()->render('index.html.twig');
    }
}