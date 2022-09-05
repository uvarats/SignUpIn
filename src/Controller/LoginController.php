<?php

declare(strict_types=1);

namespace App\Controller;

use App\Json;
use App\Service\UserService;
use App\View;

class LoginController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function signinPage()
    {
        echo View::getTwig()->render('signin/index.html.twig', []);
    }

    public function formSubmit()
    {
        header('Content-Type: application/json; charset=utf-8');
        $isSuccessful = $this->userService->authenticate($_POST);

        if ($isSuccessful) {
            echo Json::encode([
                'success' => true,
            ]);
            return;
        }

        echo Json::encode([
            'errors' => $this->userService->getAuthErrors()
        ]);
    }

    public function logout()
    {
        $redirectTo = $_SERVER['HTTP_REFERER'] ?? '/';
        header('Location: ' . $redirectTo, true, 301);

        session_destroy();
    }
}
