<?php /** @noinspection PhpUndefinedClassInspection */

namespace Remcodex\Client\Http;

use Guzwrap\Wrapper\Form;
use Guzwrap\Wrapper\Guzzle;
use Guzwrap\Request as GuzRequest;
use GuzzleHttp\Exception\GuzzleException;
use Nette\Utils\Json;
use Remcodex\Client\Constructor;
use Remcodex\Client\Exceptions\Http\HttpErrorException;
use Remcodex\Client\Exceptions\Http\InvalidResponseException;

class Request extends Guzzle implements RequestInterface
{
    public const COMMAND_REQUEST = 'http.request';
    public const COMMAND_LIST_SERVERS = 'http.server.list';

    protected static string $httpAddress = 'http://localhost:9000';
    protected array $routingValues = [];

    public static function create(): Request
    {
        return new Request();
    }

    public function remoteAddress(string $httpAddress): RequestInterface
    {
        self::$httpAddress = $httpAddress;
        return $this;
    }

    /**
     * @return Response
     * @throws HttpErrorException
     * @throws GuzzleException
     * @throws InvalidResponseException
     */
    public function execute(): Response
    {
        $response = Constructor::constructRequest(
            $this,
            self::$httpAddress,
            $this->routingValues
        )->exec();

        if (200 != $response->getStatusCode()) {
            HttpErrorException::create($response, "Request ended with an error, inspect your response class for more information.");
        }

        return new Response($response);
    }

    public function router($callbackOrRouter): RequestInterface
    {
        if (is_callable($callbackOrRouter)) {
            $router = new Router();
            $callbackOrRouter($router);
            $this->routingValues = $router->getValues();
            return $this;
        }

        $this->routingValues = $callbackOrRouter->getValues();
        return $this;
    }

    public static function listServers(): array
    {
        $response = GuzRequest::form(function (Form $form){
            $form->action(self::$httpAddress);
            $form->method('post');
            $form->field('command', Request::COMMAND_LIST_SERVERS);
            $form->field('time', microtime(true));
        })->exec();

        return Json::decode($response->getBody()->getContents(), Json::FORCE_ARRAY) ?? [];
    }
}