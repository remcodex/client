# RCE Client
Remote code execution client - this library uses [Guzwrap](https://github.com/Ahmard/guzwrap) to construct request and then send it to
[RCE Server](https://github.com/remcodex/server). <br/>
[RCE Server](https://github.com/remcodex/server) will then perform the actual request and return the response to the client.

## Installation 
```bash
composer require remcodex/client
```

## Usage

The following request will send request to [RCE Server](https://github.com/remcodex/server#simple-server)
```php
use Guzwrap\Core\Post;
use Guzwrap\UserAgent;
use Remcodex\Client\Http\Request;

require 'vendor/autoload.php';

$response = Request::create()
    ->post(function (Post $post){
        $post->url('http://localhost:8000');
        $post->field('name', 'Ahmard');
        $post->field('time', date('H:i:s'));
    })
    ->userAgent(UserAgent::OPERA)
    ->withCookie()
    ->debug()
    ->exec();

var_dump($response->getBody()->getContents());

```