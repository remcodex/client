<?php /** @noinspection PhpUndefinedClassInspection */


namespace Remcodex\Client\Http;


use GuzzleHttp\Exception\GuzzleException;
use Remcodex\Client\Exceptions\Http\HttpErrorException;
use Remcodex\Client\Exceptions\Http\InvalidResponseException;

interface RequestInterface extends \Guzwrap\RequestInterface
{
    /**
     * Define request bouncing behaviour
     * @param callable|Bouncer $callbackOrBouncer
     * @return RequestInterface
     */
    public function bounce($callbackOrBouncer): RequestInterface;

    /**
     * Execute request and return response
     * @return Response
     * @throws HttpErrorException
     * @throws GuzzleException
     * @throws InvalidResponseException
     */
    public function execute(): Response;
}