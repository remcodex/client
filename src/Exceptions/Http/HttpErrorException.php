<?php


namespace Remcodex\Client\Exceptions\Http;


use Exception;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class HttpErrorException extends Exception
{
    private ResponseInterface $response;


    /**
     * @param ResponseInterface $response
     * @param string $message
     * @throws HttpErrorException
     */
    public static function create(ResponseInterface $response, string $message): void
    {
        throw new HttpErrorException($response, $message);
    }

    public function __construct(ResponseInterface $response, string $message = "", int $code = 0, Throwable $previous = null)
    {
        $this->response = $response;
        parent::__construct($message, $code, $previous);
    }

    /**
     * Get response object
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}