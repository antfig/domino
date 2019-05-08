<?php
declare(strict_types=1);

namespace Tests\ValueObject;

use Domino\ValueObject\Tile;
use Domino\ValueObject\SquareNumber;
use PHPUnit\Framework\TestCase;

class TileTest extends TestCase
{
    public function testTileHasTwoSquareValues()
    {
        $tile = new Tile(new SquareNumber(1),new SquareNumber(5));

        $this->assertEquals(1, $tile->getSquareOne()->getValue());
        $this->assertEquals(5, $tile->getSquareTwo()->getValue());
    }

    public function canBeCreatedWithFactory()
    {
        $tile = Tile::createFromValues(1,5);

        $this->assertEquals(1, $tile->getSquareOne()->getValue());
        $this->assertEquals(5, $tile->getSquareTwo()->getValue());
    }

}
