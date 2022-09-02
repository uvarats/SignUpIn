<?php

declare(strict_types=1);

namespace App\Controller;

use App\Crud\UserCrud;
use App\Validator\UserValidator;
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
        $validator = new UserValidator();
        $is_success = $validator->validate($_POST);
        if ($is_success) {
            $crud = new UserCrud();
            echo json_encode([
                'success' => true,
            ]);
            return;
        }
        echo json_encode([
            'errors' => $validator->getErrors(),
        ]);
    }
}
