<?php

declare(strict_types=1);

namespace App\Crud;

use App\Entity\User;
use App\Exception\Entity\FieldNotUniqueException;
use Cerbero\JsonObjects\JsonObjects;
use JsonStreamingParser\Parser;

class UserCrud
{
    /**
     * @throws FieldNotUniqueException
     */
    public function add(User $user)
    {
        $users = json_decode(file_get_contents($_ENV['USERS_FILE']), true);
        var_dump($users);
        foreach ($users as $userArray) {
            $login = $user->getLogin();
            $email = $user->getEmail();
            if (in_array($login, $userArray)) {
                throw new FieldNotUniqueException("login", "This login is occupied");
            }
            if (in_array($email, $userArray)) {
                throw new FieldNotUniqueException("email", "This email is occupied");
            }
        }
        $users[] = $user->jsonSerialize();
        file_put_contents($_ENV['USERS_FILE'], json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK));
    }

    public function get(callable $condition): User
    {
    }

    public function update(User $user)
    {
    }

    public function delete(User $user)
    {
    }
}
