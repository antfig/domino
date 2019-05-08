<?php
declare(strict_types=1);

namespace Domino\Entity;

use Domino\Collection;
use Domino\ValueObject\Tile;

class Player
{
    /**
     * @var Collection
     */
    private $tiles;

    /**
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name  = $name;
        $this->tiles = new Collection();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param Collection $drawTiles
     */
    public function addTiles(Collection $drawTiles)
    {
        $this->tiles->merge($drawTiles);
    }

    /**
     * @param Tile $tile
     */
    public function addTile(Tile $tile)
    {
        $this->tiles->add($tile);
    }

    /**
     * @return Collection
     */
    public function getTiles(): Collection
    {
        return $this->tiles;
    }

    /**
     * Get one tile with required number to play
     *
     * @param int $leftNumber
     *
     * @return Tile|null
     */
    public function getTileWithNumber(int $leftNumber): ?Tile
    {
        return $this->tiles->filter(function (Tile $tile) use ($leftNumber) {
            return $tile->hasNumber($leftNumber);
        })->first();
    }

    /**
     * Draw one tile with number and remove him from the list of tiles
     *
     * @param int $number
     *
     * @return Tile|null
     */
    public function drawHandTile(int $number): ?Tile
    {
        $tile = $this->getTileWithNumber($number);

        $this->tiles->remove($tile);

        return $tile;
    }

}