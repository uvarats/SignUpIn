<?php

namespace App\Service;

use App\Crud\UserCrud;
use App\Entity\User;
use App\Exception\Entity\FieldNotUniqueException;
use App\Json;
use App\Validator\UserValidator;

class UserService
{
    private PasswordService $passwordService;
    private UserCrud $userCrud;
    private array $authErrors;

    public function __construct(PasswordService $passwordService)
    {
        $this->passwordService = $passwordService;
        $this->userCrud = new UserCrud($this);
    }

    public function getFromArray(array $data): User
    {
        $user = new User();
        if (isset($data['id'])) {
            $user->setId($data['id']);
        }

        $user->setLogin($data['login'])
            ->setName($data['name'])
            ->setEmail($data['email'])
            ->setPassword($data['password']);
        return $user;
    }

    public function register(): string
    {
        $validator = new UserValidator();
        $isSuccessful = $validator->validate($_POST);
        if ($isSuccessful) {
            // password hashing
            $_POST['password'] = $this->passwordService->hash($_POST['password']);
            $user = $this->getFromArray($_POST);
            try {
                $this->userCrud->add($user);
            } catch (FieldNotUniqueException $e) {
                return Json::encode([
                    'errors' => [
                        $e->getField() => [$e->getMessage()],
                    ],
                ]);
            }

            return Json::encode([
                'success' => true,
            ]);
        }
        return Json::encode([
            'errors' => $validator->getErrors(),
        ]);
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
            $errors['password'][] = 'Password is required';
            return false;
        }
        $user = $this->userCrud->get(['login' => $login])[0];
        if (!$user) {
            $errors['login'][] = 'This user does not exists!';
            return false;
        }

        $isSuccessful = $this->passwordService->verify($password, $user->getPassword());

        if ($isSuccessful) {
            $_SESSION['login'] = $user->getLogin();
            $_SESSION['name'] = $user->getName();
            $_SESSION['is_authenticated'] = true;
        } else {
            $errors['password'][] = "Incorrect password";
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
