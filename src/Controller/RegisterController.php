<?php

namespace App\Controller;

use App\View;

class RegisterController
{

    public function __construct()
    {
    }

    public function signupPage() {
        echo View::getTwig()->render('signup/index.html.twig', []);
    }
}