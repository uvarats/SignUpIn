<?php

namespace App\Annotation\Validator;

abstract class ValidationAnnotation
{
    public string $message;

    /**
     * @param string $message
     */
    public function __construct(string $message)
    {
        $this->message = $message;
    }

    abstract public function validate(?string $data): bool;
}
