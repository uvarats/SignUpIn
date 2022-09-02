<?php

namespace App\Exception\Validator;

class FieldValidationException extends \Exception
{
    private string $field;

    /**
     * @param string $field
     * @param string $message
     */
    public function __construct(string $field, string $message)
    {
        parent::__construct($message);
        $this->field = $field;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }


}