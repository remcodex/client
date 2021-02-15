<?php /** @noinspection PhpUndefinedClassInspection */

namespace Remcodex\Client\Http;

use Guzwrap\Wrapper\Guzzle;
use GuzzleHttp\Exception\GuzzleException;
use Remcodex\Client\Constructor;
use Remcodex\Client\Exceptions\Http\HttpErrorException;
use Remcodex\Client\Exceptions\Http\InvalidResponseException;

class Request extends Guzzle implements RequestInterface
{
    private static string $serverUrl = 'http://localhost:9000';
    private array $routingValues = [];

    public static function create(): Request
    {
        return new Request();
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
            self::$serverUrl,
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
}