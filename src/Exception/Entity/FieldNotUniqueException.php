<?php

declare(strict_types=1);

namespace App\Exception\Entity;

use Exception;

class FieldNotUniqueException extends Exception
{
    private string $field;
    public function __construct(string $field, string $message)
    {
        parent::__construct($message);
        $this->field = $field;
    }

    public function getField(): string
    {
        return $this->field;
    }
}