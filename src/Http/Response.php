<?php


namespace Remcodex\Client\Http;


use Nette\Utils\Json;
use Nette\Utils\JsonException;
use Psr\Http\Message\ResponseInterface;
use Remcodex\Client\Exceptions\Http\InvalidResponseException;

class Response
{
    private ResponseInterface $response;
    private bool $success;
    private array $data;
    private string $responder;

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
            $serverResp['data'] = Json::decode($serverResp['data'], Json::FORCE_ARRAY) ?? [];

            $this->checkAttribute($serverResp, 'success', 'boolean', 'is_bool');
            $this->checkAttribute($serverResp, 'data', 'string', 'is_array');
            $this->checkAttribute($serverResp, 'responder', 'string', 'is_string');

            $this->success = $serverResp['success'];
            $this->data = $serverResp['data'];
            $this->responder = $serverResp['responder'];

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
    public function status(): int
    {
        return $this->response->getStatusCode();
    }

    /**
     * Get response success attribute
     * @return bool
     */
    public function success(): bool
    {
        return $this->success;
    }

    /**
     * Get response data attribute
     * @return array
     */
    public function data(): array
    {
        return $this->data;
    }

    /**
     * Get response responder attribute
     * @return string
     */
    public function responder(): string
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