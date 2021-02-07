<?php
declare(strict_types=1);

namespace Tests;

use Domino\Board;
use Domino\Collection;
use Domino\Entity\Player;
use Domino\Exception\InvalidPlayException;
use Domino\ValueObject\Tile;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    /** @var Board */
    protected $board;

    protected function setUp(): void
    {
        $this->board = new Board();
    }

    public function testBoardHas28TilesToPlayAtWhenCreated()
    {
        $this->assertEquals(28, $this->board->getAvailableTiles()->count());
    }

    public function testCanDrawOneTile()
    {
        $tile = $this->board->drawTile();

        $this->assertInstanceOf(Tile::class, $tile);
        $this->assertEquals(27, $this->board->getAvailableTiles()->count());
    }

    public function testCanDrawMultipleTiles()
    {
        $tiles = $this->board->drawTiles(10);

        $this->assertInstanceOf(Collection::class, $tiles);
        $this->assertEquals(10, $tiles->count());
        $this->assertEquals(18, $this->board->getAvailableTiles()->count());
    }

    public function testCanOnlyPlayValidTileFromLeftSide()
    {
        $player = new Player('Me');
        $tile = Tile::createFromValues(1, 2);
        $this->board->playLeft($tile, $player);

        // game: <1:2>

        // valid play with first element
        $validPlay = Tile::createFromValues(3, 1);
        $this->board->playLeft($validPlay, $player);
        $this->assertEquals(2, $this->board->getPlayedTiles()->count());

        // game: <3:1> <1:2>

        // valid play with second element
        $validPlay = Tile::createFromValues(3, 4);
        $this->board->playLeft($validPlay, $player);
        $this->assertEquals(3, $this->board->getPlayedTiles()->count());

        // game: <4:3> <3:1> <1:2>

        // invalid play for the left (but valid for the right)
        $invalidPlay = Tile::createFromValues(2, 5);

        $this->expectException(InvalidPlayException::class);

        $this->board->playLeft($invalidPlay, $player);
    }

    public function testCanOnlyPlayValidTileFromRightSide()
    {
        $player = new Player('Me');
        $tile = Tile::createFromValues(1, 2);
        $this->board->playRight($tile, $player);

        // game: <1:2>

        // valid play with first element
        $validPlay = Tile::createFromValues(0, 2);
        $this->board->playRight($validPlay, $player);
        $this->assertEquals(2, $this->board->getPlayedTiles()->count());

        // game: <1:2> <2:0>

        // valid play with second element
        $validPlay = Tile::createFromValues(3, 0);
        $this->board->playRight($validPlay, $player);
        $this->assertEquals(3, $this->board->getPlayedTiles()->count());

        // game: <1:2> <2:0> <0:3>

        // invalid play for the right (but valid for the left)
        $invalidPlay = Tile::createFromValues(1, 4);

        $this->expectException(InvalidPlayException::class);

        $this->board->playRight($invalidPlay, $player);
    }

    public function testCanOnlyPlayFirstOnce()
    {
        $tile = Tile::createFromValues(1, 2);

        $this->board->playFirst($tile);

        $this->expectException(InvalidPlayException::class);

        $this->board->playFirst($tile);
    }

    public function testCanNotPlaySameTileTwice()
    {
        $player = new Player('Me');
        $tile1 = Tile::createFromValues(1, 2);
        $tile2 = Tile::createFromValues(1, 5);

        $this->board->playFirst($tile1);
        $this->board->playLeft($tile2, $player);

        $this->expectException(InvalidPlayException::class);

        $this->board->playLeft($tile2, $player);
    }
}
