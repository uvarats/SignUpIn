<?php

namespace App\Annotation\Validator;

use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @Annotation
 * @NamedArgumentConstructor
 * @Target("PROPERTY")
 */
class Required extends ValidationAnnotation
{
    /**
     * @param string $message
     */
    public function __construct(string $message = "This field is required")
    {
        parent::__construct($message);
    }

    /**
     * @param string|null $data
     * @return bool
     */
    public function validate(?string $data): bool
    {
        return !empty($data);
    }
}
