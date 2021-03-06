<?php

require 'vendor/autoload.php';

use Guzwrap\UserAgent;
use Guzwrap\Wrapper\Form;
use Remcodex\Client\Http\Request;
use Remcodex\Client\Http\Router;


try {
    $response = Request::create()
        ->post(function (Form $form) {
            $form->action('http://localhost:8000');
            $form->method('post');
            $form->field('name', 'Ahmard');
            $form->field('time', date('H:i:s'));
        })
        ->router(function (Router $router){
            //Choose server geo-location(if available)
            $router->serverLocation('asia.indonesia');
            //Choose specific server
            $router->serverHost('http://localhost:9100');
            //How many times your request need to be bounced between routers before sending it to actual destination
            $router->bounce(5);
        })
        ->userAgent(UserAgent::OPERA)
        ->withCookie()
        ->execute();

    if ($response->hasError()) {
        //echo $response->getError()->getMessage();
        var_export($response->getError()->getError());
    } else {
        var_dump($response->getSuccess()->getData());
    }

} catch (Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
}
