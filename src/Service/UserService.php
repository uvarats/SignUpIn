<?php

namespace App\Service;

use App\Crud\UserCrud;
use App\Entity\User;

class UserService
{
    private PasswordService $passwordService;
    private UserCrud $userCrud;
    private array $authErrors;

    public function __construct(PasswordService $passwordService, UserCrud $userCrud)
    {
        $this->passwordService = $passwordService;
        $this->userCrud = $userCrud;
    }

    public function getFromArray(array $data): User
    {
        $user = new User();
        if (isset($data['id'])) {
            $user->setId($data['id']);
        }

        $hashedPassword = $this->passwordService->hash($data['password']);

        $user->setLogin($data['login'])
            ->setName($data['name'])
            ->setEmail($data['email'])
            ->setPassword($hashedPassword);
        return $user;
    }

    public function authenticate(array $credentials): bool
    {
        $login = $credentials['login'];
        $password = $credentials['password'];

        $this->authErrors = [];
        $errors = &$this->authErrors;

        if (empty($login)) {
            $errors['login'][] = 'Login is required';
        }
        if (empty($password)) {
            $errors['password'][] = 'Login is required';
        }
        $user = $this->userCrud->get(['login' => $login])[0];
        if (!$user) {
            $errors['login'] = 'This user does not exists!';
        }

        $isSuccessful = $this->passwordService->verify($password, $user->getPassword());

        if ($isSuccessful) {
            /**
             * TODO: Start Session and store user in session
             */
            session_start();
            $_SESSION['login'] = $user->getLogin();
            $_SESSION['name'] = $user->getName();
            $_SESSION['is_authenticated'] = true;
        }

        return $isSuccessful;
    }

    /**
     * @return array
     */
    public function getAuthErrors(): array
    {
        return $this->authErrors;
    }
}
