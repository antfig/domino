<?php
declare(strict_types=1);

namespace Domino\ValueObject;

use Domino\Contracts\PlayInterface;
use Domino\Entity\Player;
use Domino\Exception\InvalidTilePlayAssociationException;

final class TilePlay implements PlayInterface
{
    /**
     * @var Tile
     */
    private $tile;

    /**
     * @var int
     */
    private $connectedNumber;

    /**
     * @var Player
     */
    private $player;

    /**
     * @param Tile $tile
     * @param int $connectedNumber
     * @param Player $player
     *
     * @throws InvalidTilePlayAssociationException
     */
    public function __construct(Tile $tile, int $connectedNumber, Player $player)
    {
        $this->ensureValidConnectedNumber($tile, $connectedNumber);
        $this->tile = $tile;
        $this->connectedNumber = $connectedNumber;
        $this->player = $player;
    }

    /**
     * @return Tile
     */
    public function getTile(): Tile
    {
        return $this->tile;
    }

    /**
     * @return int
     */
    public function getConnectedNumber(): ?int
    {
        return $this->connectedNumber;
    }

    /**
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * Get value of the not connected square
     * @return int
     */
    public function getFreeNumber(): ?int
    {
        if ($this->tile->getSquareOne()->getValue() === $this->connectedNumber) {
            return $this->tile->getSquareTwo()->getValue();
        }

        return $this->tile->getSquareOne()->getValue();
    }

    /**
     * @param Tile $tile
     * @param int $connectedNumber
     *
     * @throws InvalidTilePlayAssociationException
     */
    private function ensureValidConnectedNumber(Tile $tile, int $connectedNumber): void
    {
        if ($tile->getSquareOne()->getValue() === $connectedNumber) {
            return;
        }

        if ($tile->getSquareTwo()->getValue() === $connectedNumber) {
            return;
        }

        throw new InvalidTilePlayAssociationException('Tile not have any square with the number ' . $connectedNumber);
    }
}
