<?php
declare(strict_types=1);

namespace Tests\Entity;

use Domino\Collection;
use Domino\Entity\Player;
use Domino\ValueObject\Tile;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    public function testPlayerHasName()
    {
        $player = new Player('António');

        $this->assertEquals('António', $player->getName());
    }

    public function testCanAdOneTile()
    {
        $player = new Player('António');
        $tile = Tile::createFromValues(0,1);

        $this->assertEquals(0, $player->getTiles()->count());

        $player->addTile($tile);

        $this->assertEquals(1, $player->getTiles()->count());
        $this->assertEquals($tile, $player->getTiles()->first());
    }

    public function testCanAddMultipleTiles()
    {
        $player = new Player('António');

        $tile1 = Tile::createFromValues(0,1);
        $tile2 = Tile::createFromValues(0,4);

        $tiles = new Collection([$tile1, $tile2]);

        $player->addTiles($tiles);

        $this->assertEquals($tiles, $player->getTiles());
    }

    public function testCanGetTilesWithGivenNumber()
    {
        $player = new Player('António');

        $tile1 = Tile::createFromValues(0,1);
        $tile2 = Tile::createFromValues(0,4);

        $player->addTile($tile1);
        $player->addTile($tile2);

        $this->assertEquals($tile2, $player->getTileWithNumber(4));
        $this->assertNull($player->getTileWithNumber(3));
    }

    public function testCanDrawOneTileByNumber()
    {
        $player = new Player('António');

        $tile1 = Tile::createFromValues(0,1);
        $tile2 = Tile::createFromValues(0,4);
        $player->addTile($tile1);
        $player->addTile($tile2);

        $this->assertContains($tile1, $player->getTiles()->toArray());

        $tileDraw = $player->drawHandTile(1);

        $this->assertNotContains($tileDraw, $player->getTiles()->toArray());
        $this->assertContains($tile2, $player->getTiles()->toArray());

        $tileDrawEmpty = $player->drawHandTile(6);
        $this->assertNull($tileDrawEmpty);
    }
}
