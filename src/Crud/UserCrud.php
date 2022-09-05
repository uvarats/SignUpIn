<?php

declare(strict_types=1);

namespace App\Crud;

use App\Entity\User;
use App\Exception\Entity\FieldNotUniqueException;
use App\Json;
use App\Service\UserService;
use Cerbero\JsonObjects\JsonObjects;
use Cerbero\JsonObjects\JsonObjectsException;
use JsonStreamingParser\Parser;

class UserCrud
{
    private UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * @throws FieldNotUniqueException
     */
    public function add(User $user)
    {
        $data = json_decode(file_get_contents($_ENV['USERS_FILE']), true);
        $users = &$data['users'];
        $login = $user->getLogin();
        $email = $user->getEmail();
        foreach ($users as $node) {
            if (in_array($login, $node)) {
                throw new FieldNotUniqueException("login", "This login is occupied");
            }
            if (in_array($email, $node)) {
                throw new FieldNotUniqueException("email", "This email is occupied");
            }
        }
        $user->setId($data['last_id']++);
        $users[] = $user->jsonSerialize();
        file_put_contents(
            $_ENV['USERS_FILE'],
            Json::encode($data)
        );
    }

    /**
     * @return User[]
     */
    public function get(array $condition): array
    {
        $results = [];
        if (count($condition) > 0) {
            $key = array_keys($condition)[0];
            $users = json_decode(file_get_contents($_ENV['USERS_FILE']), true)['users'];
            foreach ($users as $node) {
                if ($node[$key] === $condition[$key]) {
                    $user = $this->userService->getFromArray($node);
                    $results[] = $user;
                }
            }
        }
        return $results;
    }

    private function action(User $user, string $action)
    {
        $data = json_decode(file_get_contents($_ENV['USERS_FILE']), true);

        $users = &$data['users'];
        $id = $user->getId();

        $index = -1;
        foreach ($users as $key => $userArray) {
            if ($userArray['id'] === $id) {
                $index = $key;
            }
        }

        if ($action === "update") {
            $users[$index] = $user->jsonSerialize();
        } elseif ($action === "delete") {
            unset($users[$index]);
        }

        file_put_contents(
            $_ENV['USERS_FILE'],
            Json::encode($data)
        );
    }

    public function update(User $user)
    {
        $this->action($user, "update");
    }

    public function delete(User $user)
    {
        $this->action($user, "delete");
    }
}
