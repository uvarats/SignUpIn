<?php

declare(strict_types=1);

namespace App\Controller;

use App\View;

class RegisterController
{
    public function __construct()
    {
    }

    public function signupPage()
    {
        echo View::getTwig()->render('signup/index.html.twig', []);
    }

    public function formSubmit(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode($_POST);
    }
}
