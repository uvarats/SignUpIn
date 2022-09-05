<?php

declare(strict_types=1);

namespace App\Controller;

use App\Crud\UserCrud;
use App\Exception\Entity\FieldNotUniqueException;
use App\Service\UserService;
use App\Validator\UserValidator;
use App\View;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class RegisterController
{
    private UserCrud $crud;
    private UserService $userService;

    /**
     * @param UserCrud $crud
     * @param UserService $userService
     */
    public function __construct(UserCrud $crud, UserService $userService)
    {
        $this->crud = $crud;
        $this->userService = $userService;
    }

    /**
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function signupPage()
    {
        echo View::getTwig()->render('signup/index.html.twig', []);
    }

    public function formSubmit(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        $validator = new UserValidator();
        $isSuccessful = $validator->validate($_POST);
        if ($isSuccessful) {
            $user = $this->userService->getFromArray($_POST);
            try {
                $this->crud->add($user);
            } catch (FieldNotUniqueException $e) {
                echo json_encode([
                    'errors' => [
                        $e->getField() => [$e->getMessage()],
                    ],
                ]);
                return;
            }

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
