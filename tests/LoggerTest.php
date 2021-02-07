<?php
declare(strict_types=1);

namespace Tests;

use Domino\Logger;
use PHPUnit\Framework\TestCase;

class LoggerTest extends TestCase
{
    public function testCanAddLogLines(): void
    {
        $logger = new Logger();
        $logger->log('foo');

        $expected = ['foo'];

        $this->assertSame($expected, $logger->getLogs());
    }
}
