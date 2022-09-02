<?php

namespace App\Annotation\Validator;

use App\Exception\Validator\FieldValidationException;
use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @Annotation
 * @NamedArgumentConstructor
 * @Target("PROPERTY")
 */
class MinLength extends ValidationAnnotation
{
    public int $length;

    public function __construct(int $length, string $message = "This field must contain at least {{ length }} characters")
    {
        $this->length = $length;
        parent::__construct(str_replace("{{ length }}", $length, $message));
    }

    public function validate(?string $data): bool
    {
        return strlen($data) >= $this->length;
    }
}
