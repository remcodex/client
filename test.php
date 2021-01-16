<?php

require 'vendor/autoload.php';

use Guzwrap\Core\Post;
use Guzwrap\UserAgent;
use Remcodex\Client\Http\Request;

$response = Request::create()
    ->post(function (Post $post){
        $post->url('http://localhost:8000');
        $post->field('name', 'Ahmard');
        $post->field('time', date('H:i:s'));
    })
    ->userAgent(UserAgent::OPERA)
    ->withCookie()
    //->debug()
    ->exec();


var_dump($response->getBody()->getContents());
