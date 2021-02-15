<?php


namespace Remcodex\Client;


use Guzwrap\Request;
use Guzwrap\RequestInterface;
use Guzwrap\Wrapper\Form;
use Nette\Utils\Json;

class Constructor
{
    /**
     * @param RequestInterface $request
     * @param string $serverUrl
     * @param array $router
     * @return RequestInterface
     */
    public static function constructRequest(RequestInterface $request, string $serverUrl, array $router = []): RequestInterface
    {
        return Request::form(function (Form $form) use ($request, $serverUrl, $router) {
            $form->action($serverUrl);
            $form->method('post');
            $form->field('command', 'http.request');
            $form->field('time', microtime(true));
            $form->field('guzwrap', Json::encode($request->getData()));
            $form->field('router', Json::encode($router));
        });
    }
}