<?php

namespace App\Controller;

use App\View;

class LoginController
{
    public function __construct()
    {
    }

    public function signinPage() {
        echo View::getTwig()->render('signin/index.html.twig', []);
    }
}