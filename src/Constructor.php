<?php


namespace Remcodex\Client;


use Guzwrap\Core\Post;
use Guzwrap\Request;
use Guzwrap\RequestInterface;
use Nette\Utils\Json;

class Constructor
{
    public static function constructRequest(RequestInterface $request, string $serverUrl): RequestInterface
    {
        return Request::post(function (Post $post) use ($request, $serverUrl) {
            $post->url($serverUrl);
            $post->field('command', 'http.request');
            $post->field('time', microtime(true));
            $post->field('guzwrap', Json::encode($request->getRequestData()));
        });
    }
}