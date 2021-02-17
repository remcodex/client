<?php


namespace Remcodex\Client;


use Guzwrap\Request as GuzRequest;
use Guzwrap\RequestInterface;
use Guzwrap\Wrapper\Form;
use Nette\Utils\Json;
use Remcodex\Client\Http\Request;

class Constructor
{
    /**
     * @param RequestInterface $request
     * @param string $serverUrl
     * @param array $router
     * @return RequestInterface
     */
    public static function constructRequest(
        RequestInterface $request,
        string $serverUrl,
        array $router = []
    ): RequestInterface
    {
        return GuzRequest::form(function (Form $form) use ($request, $serverUrl, $router) {
            $form->action($serverUrl);
            $form->method('post');
            $form->field('command', Request::COMMAND_REQUEST);
            $form->field('time', microtime(true));
            $form->field('payload', Json::encode([
                'guzwrap' => $request->getData(),
                'router' => $router
            ]));
        });
    }
}