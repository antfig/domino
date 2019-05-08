<?php
declare(strict_types=1);

namespace Tests\ValueObject;

use Domino\Exception\InvalidSquareValueException;
use Domino\ValueObject\SquareNumber;
use PHPUnit\Framework\TestCase;

class SquareTest extends TestCase
{

    public function testHasValue()
    {
        $square = new SquareNumber(1);

        $this->assertEquals(1, $square->getValue());
        $this->assertEquals('1', $square);
    }

    public function testNotAcceptValuesMinorThan0()
    {
        $this->expectException(InvalidSquareValueException::class);
        new SquareNumber(-1);
    }

    public function testNotAcceptValuesGreaterThan6()
    {
        $this->expectException(InvalidSquareValueException::class);
        new SquareNumber(7);
    }

}
