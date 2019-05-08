<?php
declare(strict_types=1);

namespace Domino\ValueObject;

use Domino\Contracts\PlayInterface;

class FirstTilePlay implements PlayInterface
{
    /**
     * @var Tile
     */
    private $tile;

    public function __construct(Tile $tile)
    {
        $this->tile = $tile;
    }

    /**
     * @return Tile
     */
    public function getTile(): Tile
    {
        return $this->tile;
    }

}
