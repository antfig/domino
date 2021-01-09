<?php
declare(strict_types=1);

namespace Domino\Contracts;

interface LoggerInterface
{

    public function getLogs(): array;

    /**
     * @param string $value
     */
    public function log(string $value): void;
}
