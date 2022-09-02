<?php

declare(strict_types=1);

namespace App\Entity;

use App\Annotation\Validator\Email;
use App\Annotation\Validator\MinLength;
use App\Annotation\Validator\Regex;
use App\Annotation\Validator\Required;

class User implements \JsonSerializable
{
    /**
     * @Required
     * @MinLength(6, "This field must contain at least 6 characters")
     */
    private string $login;

    /**
     * @Required
     * @Regex("/^([a-zA-Z]+)$/", "This field must contain only letters")
     * @MinLength(2)
     */
    private string $name;

    /**
     * @Required
     * @Email
     */
    private string $email;

    /**
     * @Required
     * @Regex("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]+$/", "This field must contain at least one letter and number")
     * @MinLength(6)
     */
    private string $password;

    public function __construct()
    {
    }

    /**
     * @param string $login
     * @return User
     */
    public function setLogin(string $login): User
    {
        $this->login = $login;
        return $this;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $name
     * @return User
     */
    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
