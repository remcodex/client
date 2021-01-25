<?php


namespace Remcodex\Client;


use Guzwrap\Wrapper\Form;
use Guzwrap\Request;
use Guzwrap\RequestInterface;
use Nette\Utils\Json;

class Constructor
{
    public static function constructRequest(RequestInterface $request, string $serverUrl): RequestInterface
    {
        return Request::form(function (Form $form) use ($request, $serverUrl) {
            $form->action($serverUrl);
            $form->method('post');
            $form->field('command', 'http.request');
            $form->field('time', microtime(true));
            $form->field('guzwrap', Json::encode($request->getData()));
        });
    }
}