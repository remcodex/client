<?php


namespace Remcodex\Client\Http;


use Nette\Utils\Json;
use Nette\Utils\JsonException;
use Psr\Http\Message\ResponseInterface;
use Remcodex\Client\Exceptions\Http\InvalidResponseException;

class Response
{
    private ResponseInterface $response;
    private bool $hasError;
    private string $responder;
    private ServerErrorResponse $serverErrorResponse;
    private ServerSuccessResponse $serverSuccessResponse;


    /**
     * Response constructor.
     * @param ResponseInterface $response
     * @throws InvalidResponseException
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
        try {
            $serverResp = Json::decode($response->getBody()->getContents(), Json::FORCE_ARRAY);
            if (!isset($serverResp['success'])) {
                InvalidResponseException::create($response, 'Server response is in invalid format, please check docs for supported response type.');
            }

            if ($serverResp['success']) {
                $serverResp['data'] = Json::decode($serverResp['data'], Json::FORCE_ARRAY) ?? [];

                $this->checkAttribute($serverResp, 'data', 'string', 'is_array');
                $this->checkAttribute($serverResp, 'responder', 'string', 'is_string');

                $this->hasError = !$serverResp['success'];
                $this->responder = $serverResp['responder'];
                $this->serverSuccessResponse = new ServerSuccessResponse($serverResp['data']);
            }else{
                $this->hasError = true;
                $this->serverErrorResponse = new ServerErrorResponse($serverResp);
            }

        } catch (JsonException $e) {
            InvalidResponseException::create($response, "Returned json response is in invalid format.");
        }
    }

    /**
     * @param array $serverResp
     * @param string $name
     * @param string $type
     * @param callable $checkFunction
     * @throws InvalidResponseException
     */
    private function checkAttribute(array $serverResp, string $name, string $type, callable $checkFunction): void
    {
        if (!isset($serverResp[$name]) || !$checkFunction($serverResp[$name])) {
            InvalidResponseException::create($this->response, "{$name} status attribute must exits and of {$type} type.");
        }
    }

    /**
     * Get response http status code
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->response->getStatusCode();
    }

    /**
     * CHeck if response finishes with success or error
     * @return bool
     */
    public function hasError(): bool
    {
        return $this->hasError;
    }

    /**
     * Get response data
     * @return ServerSuccessResponse|null
     */
    public function getSuccess(): ?ServerSuccessResponse
    {
        return $this->serverSuccessResponse ?? null;
    }

    /**
     * Get response error
     * @return ServerErrorResponse|null
     */
    public function getError(): ?ServerErrorResponse
    {
        return $this->serverErrorResponse ?? null;
    }

    /**
     * Get response responder attribute
     * @return string
     */
    public function getResponder(): string
    {
        return $this->responder;
    }

    /**
     * Get http response object
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}