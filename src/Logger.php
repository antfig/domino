<?php
declare(strict_types=1);

namespace Domino;

use Domino\Contracts\LoggerInterface;

class Logger implements LoggerInterface
{
    /**
     * @var array<int,string>
     */
    private $logs = [];

    /**
     * @inheritDoc
     */
    public function log(string $value): void
    {
        $this->logs[] = $value;
    }

    /**
     * @inheritDoc
     */
    public function getLogs(): array
    {
        return $this->logs;
    }
}
