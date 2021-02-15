<?php


namespace Remcodex\Client\Http;


class ServerErrorResponse
{
    private array $error;

    public function __construct(array $error)
    {
        $this->error = $error;
    }

    /**
     * Get decoded error
     * @return array
     */
    public function getError(): array
    {
        return $this->error;
    }

    /**
     * Get error code
     * @return string
     */
    public function getCode(): string
    {
        return $this->error['data']['code'];
    }

    /**
     * Get error message
     * @return string
     */
    public function getMessage(): string
    {
        return $this->error['data']['message'];
    }
}