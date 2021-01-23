<?php


namespace Remcodex\Client\Http;


interface RequestInterface extends \Guzwrap\RequestInterface
{
    /**
     * Define request bouncing behaviour
     * @param callable|Bouncer $callbackOrBouncer
     * @return RequestInterface
     */
    public function bounce($callbackOrBouncer): RequestInterface;
}