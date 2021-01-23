<?php

namespace Remcodex\Client\Http;

use Guzwrap\Core\GuzzleWrapper;
use Psr\Http\Message\ResponseInterface;
use Remcodex\Client\Constructor;

class Request extends GuzzleWrapper implements RequestInterface
{
    private static string $serverUrl = 'http://localhost:9000';
    private array $bouncingValues;

    public static function create(): Request
    {
        return new Request();
    }

    public function exec(): ResponseInterface
    {
        return Constructor::constructRequest($this, self::$serverUrl)->exec();
    }

    public function bounce($callbackOrBouncer): RequestInterface
    {
        if (is_callable($callbackOrBouncer)) {
            $bouncer = new Bouncer();
            $callbackOrBouncer($bouncer);
            $this->bouncingValues = $bouncer->getValues();
            return $this;
        }

        $this->bouncingValues = $callbackOrBouncer->getValues();
        return $this;
    }
}