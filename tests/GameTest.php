<?php
/*declare(strict_types=1);

namespace Tests;

use Domino\Collection;
use Domino\Entity\Player;
use Domino\Game;
use Domino\Logger;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    public function testPlayerShouldWin()
    {
        // create dependencies for the game
        $logger = new Logger();

        $players = new Collection();

        $playerOne = new Player('Mark');
        $players->add($playerOne);

        $game = new Game($players, $logger);

        $game->run();

        $logsReversed = array_reverse($logger->getLogs());

        $lastLog = reset($logsReversed);
        $this->assertContains('Player Mark has won!', $lastLog);
    }


}*/
