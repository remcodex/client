<?php


namespace Remcodex\Client\Http;


interface RequestInterface extends \Guzwrap\RequestInterface
{
    public function execute(): RequestInterface;
}