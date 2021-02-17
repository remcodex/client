<?php /** @noinspection PhpUndefinedClassInspection */


namespace Remcodex\Client\Http;


use GuzzleHttp\Exception\GuzzleException;
use Remcodex\Client\Exceptions\Http\HttpErrorException;
use Remcodex\Client\Exceptions\Http\InvalidResponseException;

interface RequestInterface extends \Guzwrap\RequestInterface
{
    /**
     * Set server/router http address
     * @param string $httpAddress
     * @return $this
     */
    public function remoteAddress(string $httpAddress): RequestInterface;

    /**
     * @param callable|Router $callbackOrRouter
     * @return $this
     */
    public function router($callbackOrRouter): RequestInterface;

    /**
     * Execute request and return response
     * @return Response
     * @throws HttpErrorException
     * @throws GuzzleException
     * @throws InvalidResponseException
     */
    public function execute(): Response;

    /**
     * List remote servers hosted in the router
     * @return array
     */
    public static function listServers(): array;
}