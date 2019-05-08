<?php
declare(strict_types=1);

namespace Tests\ValueObject;

use Domino\Entity\Player;
use Domino\Exception\InvalidTilePlayAssociationException;
use Domino\ValueObject\Tile;
use Domino\ValueObject\TilePlay;
use PHPUnit\Framework\TestCase;

class TilePlayTest extends TestCase
{

    public function testPlayHasTileAndConnectedNumberAndPlayer()
    {
        $player = new Player('Me');
        $tile   = Tile::createFromValues(1, 2);

        // right side connection
        $play = new TilePlay($tile, 2, $player);

        $this->assertEquals($tile, $play->getTile());
        $this->assertEquals(2, $play->getConnectedNumber());
        $this->assertEquals(1, $play->getFreeNumber());
        $this->assertEquals($player, $play->getPlayer());

        // left side connection
        $play = new TilePlay($tile, 1, $player);

        $this->assertEquals($tile, $play->getTile());
        $this->assertEquals(1, $play->getConnectedNumber());
        $this->assertEquals(2, $play->getFreeNumber());
        $this->assertEquals($player, $play->getPlayer());
    }

    public function testCanNotPlayWithWrongConnectedNumber()
    {
        $player = new Player('Me');
        $tile   = Tile::createFromValues(1, 2);

        $this->expectException(InvalidTilePlayAssociationException::class);

        new TilePlay($tile, 3, $player);
    }
}
