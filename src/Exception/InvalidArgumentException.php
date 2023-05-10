<?php

declare(strict_types=1);

namespace Netzmacht\Html\Exception;

use Exception;

class InvalidArgumentException extends Exception
{
    /**
     * @param string       $message      Exception message.
     * @param int          $code         Error code.
     * @param string|null  $propertyPath Property path.
     * @param mixed        $value        Given value.
     * @param list<string> $constraints  Constraints.
     */
    public function __construct(
        string $message,
        int $code,
        private readonly string|null $propertyPath = null,
        private readonly mixed $value = null,
        private readonly array $constraints = [],
    ) {
        parent::__construct($message, $code);
    }

    /**
     * User controlled way to define a sub-property causing the failure of a currently asserted objects.
     *
     * Useful to transport information about the nature of the error back to higher layers.
     */
    public function getPropertyPath(): string
    {
        return $this->propertyPath;
    }

    /**
     * Get the value that caused the assertion to fail.
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * Get the constraints that applied to the failed assertion.
     *
     * @return list<string>
     */
    public function getConstraints(): array
    {
        return $this->constraints;
    }
}
