<?php
declare(strict_types=1);

namespace Domino;

use Domino\Contracts\LoggerInterface;
use Domino\Entity\Player;
use Domino\ValueObject\Tile;
use Domino\ValueObject\TilePlay;

class Game
{
    /**
     * @var Board
     */
    protected $board;

    /**
     * @var Collection
     */
    protected $players;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @param Collection $players
     * @param LoggerInterface $logger
     *
     * @throws Exception\BoardException
     * @throws Exception\InvalidPlayException
     */
    public function __construct(Collection $players, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->players = $players;
        $this->initGame();
    }

    /**
     * @throws Exception\BoardException
     */
    public function initGame()
    {
        $this->board = new Board();

        // draw one tile to start the game
        $firstTile = $this->board->drawTile();

        $this->logger->log(sprintf("\nGame starting with first tile: <%s:%s>",
            $firstTile->getSquareOne(),
            $firstTile->getSquareTwo()));

        $this->board->playFirst($firstTile);

        // add 7 tiles to each player
        foreach ($this->players as $player) {
            $player->addTiles($this->board->drawTiles(7));
        }
    }

    /**
     * @return Board
     */
    public function getBoard(): Board
    {
        return $this->board;
    }

    /**
     * @throws Exception\InvalidPlayException
     */
    public function run()
    {
        $hasWinner = false;

        while (!$hasWinner) {

            foreach ($this->players as $player) {

                $playedTile = $this->playerMove($player);

                // no more tiles in the board
                if ($playedTile === null) {
                    $this->logger->log("\nNo more tiles in the board");
                    break 2;
                }

                $currentBoard = "\nBoard is now: ";

                foreach ($this->board->getPlayedTiles() as $tilePlay) {
                    $currentBoard .= sprintf("<%s:%s>(%s)",
                        $tilePlay->getTile()->getSquareOne()->getValue(),
                        $tilePlay->getTile()->getSquareTwo()->getValue(),
                        $tilePlay instanceof TilePlay ? $tilePlay->getConnectedNumber() : ''
                    );
                }

                $this->logger->log($currentBoard);

                if ($player->getTiles()->count() === 0) {
                    $hasWinner = true;
                    $this->logger->log(sprintf("\nPlayer %s has won!", $player->getName()));
                    break;
                }
            }
        }

    }

    /**
     * Try to do a play by the player
     *
     * @param Player $player
     *
     * @return bool
     * @throws Exception\InvalidPlayException
     */
    private function play(Player $player): ?Tile
    {
        // check if player have available move on left side
        $leftNumber = $this->board->getLeftPlayableNumber();

        // get one tile to play if they have one
        $tileToPlayLeft = $player->drawHandTile($leftNumber);

        if ($tileToPlayLeft !== null) {
            $this->board->playLeft($tileToPlayLeft, $player);
            return $tileToPlayLeft;
        }

        // check in right side to play
        $rightNumber = $this->board->getRightPlayableNumber();

        // get one tile to play if they have one
        $tileToPlayRight = $player->drawHandTile($rightNumber);

        if ($tileToPlayRight !== null) {
            $this->board->playRight($tileToPlayRight, $player);
            return $tileToPlayRight;
        }

        return null;
    }

    /**
     * @param Player $player
     *
     * @return Tile|null
     * @throws Exception\InvalidPlayException
     */
    private function playerMove(Player $player): ?Tile
    {
        // play until he has a valid move
        do {
            $playedTile = $this->play($player);// if not played draw another one

            if ($playedTile === null) {

                $tileFromBoard = $this->board->drawTile();

                // no more tiles in the board to draw
                if ($tileFromBoard === null) {
                    return null;
                }

                $this->logger->log(
                    sprintf("\n%s can't play, drawing tile <%s:%s>",
                        $player->getName(),
                        $tileFromBoard->getSquareOne()->getValue(),
                        $tileFromBoard->getSquareTwo()->getValue()
                    )
                );

                $player->addTile($tileFromBoard);
            }

        } while ($playedTile === null);


        $this->logger->log(
            sprintf("\n%s (%s) played <%s:%s>",
                $player->getName(),
                $player->getTiles()->count(),
                $playedTile->getSquareOne()->getValue(),
                $playedTile->getSquareTwo()->getValue()
            )
        );

        return $playedTile;
    }

}
