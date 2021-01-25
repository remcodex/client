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
    private array $bouncingValues;

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
        $response = Constructor::constructRequest($this, self::$serverUrl)->exec();
        if (200 != $response->getStatusCode()) {
            HttpErrorException::create($response, "Request ended with an error, inspect your response class for more information.");
        }

        return new Response($response);
    }

    public function bounce($callbackOrBouncer): RequestInterface
    {
        if (is_callable($callbackOrBouncer)) {
            $bouncer = new Bouncer();
            $callbackOrBouncer($bouncer);
            $this->bouncingValues = $bouncer->getValues();
            return $this;
        }

        $this->bouncingValues = $callbackOrBouncer->getValues();
        return $this;
    }
}