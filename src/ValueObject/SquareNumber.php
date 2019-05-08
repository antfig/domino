<?php
declare(strict_types=1);

namespace Domino\ValueObject;

use Domino\Exception\InvalidSquareValueException;

class SquareNumber
{
    /**
     * @var int
     */
    private $value;

    /**
     * @param int $value
     * @throws InvalidSquareValueException
     */
    public function __construct(int $value)
    {
        $this->ensureValidValue($value);
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    public function __toString()
    {
        return (string)$this->getValue();
    }

    /**
     * @param int $value
     * @throws InvalidSquareValueException
     */
    private function ensureValidValue(int $value): void
    {
        if ($value < 0 || $value > 6) {
            throw new InvalidSquareValueException('Square can only accepts values between 0 and 6, ' . $value . " given");
        }
    }

}
