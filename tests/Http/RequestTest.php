<?php

namespace Remcodex\Client\Tests\Http;

use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testRequestGeneration(): void
    {
        $request = (new Request)
            ->get('http://localhost:8000')
            ->getExecuteData();

        self::assertSame('GET', $request['method']);
    }
}
