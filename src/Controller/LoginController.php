<?php

declare(strict_types=1);

namespace App\Controller;

use App\Json;
use App\View;

class LoginController
{
    public function __construct()
    {
    }

    public function signinPage()
    {
        echo View::getTwig()->render('signin/index.html.twig', []);
    }

    public function formSubmit()
    {
        header('Content-Type: application/json; charset=utf-8');

        echo Json::encode($_POST);
    }

    public function logout()
    {
    }
}
