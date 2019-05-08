<?php
declare(strict_types=1);

namespace Domino;

use Domino\Contracts\PlayInterface;
use Domino\Entity\Player;
use Domino\Exception\BoardException;
use Domino\Exception\InvalidPlayException;
use Domino\ValueObject\FirstTilePlay;
use Domino\ValueObject\Tile;
use Domino\ValueObject\TilePlay;

class Board
{
    /**
     * @var Collection
     */
    private $availableTiles;

    /**
     * @var Collection
     */
    private $playedTiles;


    public function __construct()
    {
        $this->availableTiles = new Collection();
        $this->playedTiles = new Collection();

        $this->initTiles();
    }

    /**
     * @return Collection
     */
    public function getAvailableTiles(): Collection
    {
        return $this->availableTiles;
    }

    /**
     * Get and remove one random tile
     *
     * @return Tile
     */
    public function drawTile(): ?Tile
    {
        $this->availableTiles->shuffle();
        return $this->availableTiles->shift();
    }

    /**
     *
     * Get and remove multiple tiles
     *
     * @param int $number
     *
     * @return Collection
     */
    public function drawTiles(int $number): Collection
    {
        $this->availableTiles->shuffle();
        return $this->availableTiles->shiftMany($number);
    }

    /**
     * @return Collection
     */
    public function getPlayedTiles(): Collection
    {
        return $this->playedTiles;
    }

    /**
     * @return int|null
     */
    public function getLeftPlayableNumber(): ?int
    {
        /** @var TilePlay $leftElement */
        $element = $this->playedTiles->first();

        // empty board
        if ($element === null) {
            return null;
        }

        if ($element instanceof FirstTilePlay) {
            return $element->getTile()->getSquareOne()->getValue();
        }

        return $element->getFreeNumber();
    }

    /**
     * @return int|null
     */
    public function getRightPlayableNumber(): ?int
    {
        /** @var TilePlay $leftElement */
        $element = $this->playedTiles->last();

        // empty board
        if ($element === null) {
            return null;
        }

        if ($element instanceof FirstTilePlay) {
            return $element->getTile()->getSquareTwo()->getValue();
        }

        return $element->getFreeNumber();
    }

    /**
     * Play the Tile at the left side of the board
     *
     * @param Tile $tile
     *
     * @param Player $player
     *
     * @throws InvalidPlayException
     */
    public function playLeft(Tile $tile, Player $player)
    {
        $numberToConnect = $this->getLeftPlayableNumber();

        // first play
        if ($numberToConnect === null) {
            $this->playedTiles->add(new FirstTilePlay($tile));
            return;
        }

        $this->ensureValidPlay($tile, $numberToConnect);

        $this->playedTiles->prepend(new TilePlay($tile, $numberToConnect, $player));
    }

    /**
     * @param Tile $tile
     *
     * @param Player $player
     *
     * @throws InvalidPlayException
     */
    public function playRight(Tile $tile, Player $player)
    {
        $numberToConnect = $this->getRightPlayableNumber();

        // first play
        if ($numberToConnect === null) {
            $this->playedTiles->add(new FirstTilePlay($tile));
            return;
        }

        $this->ensureValidPlay($tile, $numberToConnect);

        $this->getPlayedTiles()->add(new TilePlay($tile, $numberToConnect, $player));
    }

    /**
     * Play first tile
     *
     * @param Tile $tile
     *
     * @throws BoardException
     */
    public function playFirst(Tile $tile): void
    {
        if ($this->playedTiles->count() > 0) {
            throw new InvalidPlayException("Can't not call playFirst when board has played tiles already");
        }

        $this->playedTiles->add(new FirstTilePlay($tile));
    }

    /**
     * Create all 28 tiles for the game
     */
    private function initTiles()
    {
        for ($valueOne = 0; $valueOne <= 6; $valueOne++) {
            // start the value two with valueOne to not duplicate tiles
            // for example have <1:2> and <2:1> that are the same tile in diferent orientation
            for ($valueTwo = $valueOne; $valueTwo <= 6; $valueTwo++) {
                $this->availableTiles->add(Tile::createFromValues($valueOne, $valueTwo));
            }
        }
    }

    /**
     * @param Tile $tile
     * @param int $numberToConnect
     *
     * @throws InvalidPlayException
     */
    private function ensureValidPlay(Tile $tile, int $numberToConnect)
    {
        if (!$tile->hasNumber($numberToConnect)) {
            throw new InvalidPlayException("Tile don't have the given number: " . $numberToConnect);
        }


        $timesPlayed = $this->playedTiles->filter(function (PlayInterface $playedTile) use ($tile){
            return $playedTile->getTile() === $tile;
        })->count();

        if ($timesPlayed > 0) {
            throw new InvalidPlayException("A tile can only be played once.");
        }
    }

}
