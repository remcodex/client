<?php


namespace Remcodex\Client\Tests\Http;


use Guzwrap\RequestInterface;
use Remcodex\Client\Constructor;
use Remcodex\Client\Http\Request as OriginalRequest;

class Request extends OriginalRequest
{
    public function getExecuteData(): array
    {
        return Constructor::constructRequest(
            $this,
            static::$httpAddress,
            $this->routingValues
        )->getData();
    }
}