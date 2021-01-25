<?php

require 'vendor/autoload.php';

use Guzwrap\Wrapper\Form;
use Guzwrap\UserAgent;
use GuzzleHttp\Exception\GuzzleException;
use Nette\Utils\Json;
use Remcodex\Client\Exceptions\Http\HttpErrorException;
use Remcodex\Client\Exceptions\Http\InvalidResponseException;
use Remcodex\Client\Http\Request;

try {
    $response = Request::create()
        ->post(function (Form $form) {
            $form->action('http://localhost:8000');
            $form->method('post');
            $form->field('name', 'Ahmard');
            $form->field('time', date('H:i:s'));
        })
        ->userAgent(UserAgent::OPERA)
        ->withCookie()
        ->execute();
    var_dump($response->data());
} catch (GuzzleException | InvalidResponseException | HttpErrorException $e) {
    var_export((string)$e->getMessage());
}

