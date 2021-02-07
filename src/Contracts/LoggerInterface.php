<?php
declare(strict_types=1);

namespace Domino\Contracts;

interface LoggerInterface
{
    /**
     * Return log entries
     *
     * @return array<int,string>
     */
    public function getLogs(): array;

    /**
     * Add one log entry
     *
     * @param string $value
     */
    public function log(string $value): void;
}
