<?php
declare(strict_types=1);

namespace Domino;

use Domino\Contracts\LoggerInterface;

class Logger implements LoggerInterface
{
    /**
     * @var array
     */
    private $logs = [];

    /**
     * @param string $value
     */
    public function log(string $value): void
    {
        $this->logs[] = $value;
    }

    public function getLogs(): array
    {
        return $this->logs;
    }
}
