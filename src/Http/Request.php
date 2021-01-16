<?php

namespace Remcodex\Client\Http;

use Guzwrap\Core\GuzzleWrapper;
use Guzwrap\Core\Post;
use Nette\Utils\Json;
use Psr\Http\Message\ResponseInterface;

class Request extends GuzzleWrapper implements RequestInterface
{
    private static string $serverUrl = 'http://localhost:9000';

    public static function create(): Request
    {
        return new Request();
    }

    public function exec(): ResponseInterface
    {
        return \Guzwrap\Request::post(function (Post $post) {
            $post->url(self::$serverUrl);
            $post->field('data', Json::encode(self::getRequestData()));
        })->exec();
    }

    public function execute(): RequestInterface
    {
        return $this;
    }
}