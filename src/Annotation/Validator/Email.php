<?php

namespace App\Annotation\Validator;

use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
class Email extends ValidationAnnotation
{
    public function __construct()
    {
        parent::__construct("Please enter valid email");
    }

    public function validate(?string $data): bool
    {
        if ($data) {
            return filter_var($data, FILTER_VALIDATE_EMAIL);
        }
        return false;
    }
}
