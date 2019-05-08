<?php
declare(strict_types=1);

namespace Domino\Contracts;

use Domino\ValueObject\Tile;

interface PlayInterface
{

    /**
     * @return Tile
     */
    public function getTile(): Tile;
}
