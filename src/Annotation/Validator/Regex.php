<?php

namespace App\Annotation\Validator;

use Doctrine\Common\Annotations\Annotation\Attribute;
use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @Annotation
 * @NamedArgumentConstructor
 * @Target("PROPERTY")
 */
class Regex extends ValidationAnnotation
{
    public string $regex;

    /**
     * @param string $regex
     * @param string $message
     */
    public function __construct(string $regex, string $message)
    {
        $this->regex = $regex;
        parent::__construct($message);
    }

    public function validate(?string $data): bool
    {
        return boolval(preg_match($this->regex, $data));
    }
}