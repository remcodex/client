# RCE Client

Remote code execution client - this library uses [Guzwrap](https://github.com/Ahmard/guzwrap) to construct request and
then send it to
[RCE Server](https://github.com/remcodex/server). <br/>
[RCE Server](https://github.com/remcodex/server) will then perform the actual request and return the response to the
client.

## Notice 🔊

This project is currently receiving massive updates, which may include code refactoring, namespace change, and many
other stuffs that may cause the code to brake or not work entirely.<br/>
**This project is not ready!!!**

## Installation

```bash
composer require remcodex/client
```

## Usage

The following request will send request to [RCE Server](https://github.com/remcodex/server#simple-server)

```php
use Guzwrap\Wrapper\Form;
use Guzwrap\UserAgent;
use Remcodex\Client\Http\Request;

require 'vendor/autoload.php';

$response = Request::create()
    ->post(function (Form $form){
        $form->action('http://localhost:8000');
        $form->method('post');
        $form->field('name', 'Ahmard');
        $form->field('time', date('H:i:s'));
    })
    ->userAgent(UserAgent::OPERA)
    ->withSharedCookie()
    ->debug()
    ->execute();

var_dump($response->getSuccess());
```
