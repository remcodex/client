<?php


namespace Remcodex\Client\Http;


use Nette\Utils\Json;
use Nette\Utils\JsonException;

class ServerSuccessResponse
{
    private array $successData;

    /**
     * ServerSuccessResponse constructor.
     * @param array $successData
     */
    public function __construct(array $successData)
    {
        $this->successData = $successData;
    }

    /**
     * Get json decoded response data
     * @return array
     */
    public function getData(): array
    {
        return $this->successData;
    }
}