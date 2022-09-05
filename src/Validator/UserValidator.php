<?php

declare(strict_types=1);

namespace App\Validator;

use App\Annotation\Validator\ValidationAnnotation;
use App\Entity\User;
use App\Exception\Validator\FieldValidationException;
use Doctrine\Common\Annotations\AnnotationReader;
use ReflectionClass;

class UserValidator
{
    private array $errors;

    public function __construct()
    {
        $this->errors = [];
    }


    /**
     * @param array $data
     * @return bool
     */
    public function validate(array $data): bool
    {
        $reader = new AnnotationReader();
        $class = new ReflectionClass(User::class);
        foreach ($class->getProperties() as $property) {
            $field = $property->getName();

            $annotations = $reader->getPropertyAnnotations($property);
            foreach ($annotations as $annotation) {
                if ($annotation instanceof ValidationAnnotation) {
                    if (!$annotation->validate($data[$field])) {
                        $this->errors[$field][] = $annotation->message;
                    }
                }
            }
        }
        return empty($this->errors);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
