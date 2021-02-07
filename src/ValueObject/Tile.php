<?php
declare(strict_types=1);

namespace Domino\ValueObject;

use Domino\Exception\InvalidSquareValueException;

final class Tile
{
    /**
     * @var SquareNumber
     */
    protected $squareOne;

    /**
     * @var SquareNumber
     */
    protected $squareTwo;

    public function __construct(SquareNumber $squareOne, SquareNumber $squareTwo)
    {
        $this->squareOne = $squareOne;
        $this->squareTwo = $squareTwo;
    }

    /**
     * Factory
     *
     * @param int $valueOne
     * @param int $valueTwo
     * @throws InvalidSquareValueException
     *
     * @return self
     */
    public static function createFromValues(int $valueOne, int $valueTwo): self
    {
        return new self(new SquareNumber($valueOne), new SquareNumber($valueTwo));
    }

    /**
     * @return SquareNumber
     */
    public function getSquareOne(): SquareNumber
    {
        return $this->squareOne;
    }

    /**
     * @return SquareNumber
     */
    public function getSquareTwo(): SquareNumber
    {
        return $this->squareTwo;
    }

    /**
     * Check if tile has some number
     * @param int $number
     *
     * @return bool
     */
    public function hasNumber(int $number): bool
    {
        return $this->squareOne->getValue() === $number
            || $this->squareTwo->getValue() === $number;
    }
}
