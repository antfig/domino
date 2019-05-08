<?php
declare(strict_types=1);

use Domino\Collection;
use Domino\Entity\Player;
use Domino\Game;
use Domino\Logger;

// Register the autoloader
require_once __DIR__ . '/vendor/autoload.php';


// create dependencies for the game
$logger = new Logger();

$players = new Collection();
$players->add(new Player('Mark'));
$players->add(new Player('Bob'));

$game = new Game($players, $logger);

$game->run();

// echo all the trace of the game
foreach ($logger->getLogs() as $log) {
    echo $log;
}


