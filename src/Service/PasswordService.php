<?php

namespace App\Service;

class PasswordService
{
    public function hash(string $password): string
    {
        $pepperedPassword = hash_hmac('sha1', $password, $_ENV['PEPPER']);
        return password_hash($pepperedPassword, PASSWORD_BCRYPT);
    }

    public function verify(string $password, string $hash): bool
    {
        $pepperedPassword = hash_hmac('sha1', $password, $_ENV['PEPPER']);
        return password_verify($pepperedPassword, $hash);
    }
}
