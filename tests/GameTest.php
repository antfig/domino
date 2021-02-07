<?php
declare(strict_types=1);

namespace Tests;

use Domino\Board;
use Domino\Collection;
use Domino\Entity\Player;
use Domino\Game;
use Domino\Logger;
use PHPUnit\Framework\TestCase;
use function Couchbase\defaultDecoder;
use function PHPStan\dumpType;

class GameTest extends TestCase
{
    public function testGameStartsByAdd7TilesToEachPlayerAnd1TileInTheBoard(): void
    {
        // create dependencies for the game
        $logger = new Logger();

        $players = new Collection();
        $playerOne = new Player('Mark');
        $playerTwo = new Player('Mark');
        $players->add($playerOne);
        $players->add($playerTwo);

        $game = new Game($players, $logger);

        $this->assertSame($players, $game->getPlayers());

        // check player tiles
        $this->assertSame(7, $playerOne->getTiles()->count());
        $this->assertSame(7, $playerTwo->getTiles()->count());

        // check tiles in the board
        $this->assertSame(1, $game->getBoard()->getPlayedTiles()->count(), 'Board must have 1 tile');

        // Start tiles: 28
        // Used tiles: 7 to each player and 1 in the board
        $this->assertSame(13, $game->getBoard()->getAvailableTiles()->count(), 'Board must only have 13 tiles available');
    }

    public function testCanSimulateGame()
    {
        // create dependencies for the game
        $logger = new Logger();

        $players = new Collection();

        // only one player
        $playerOne = new Player('Mark');
        $players->add($playerOne);

        $game = new Game($players, $logger);

        $game->run();

        // since the game can be won or not we can only check that existed plays
        $this->assertGreaterThan(1,  $logger->getLogs());
    }
}
