<?php


namespace Remcodex\Client\Http;


class Router
{
    private array $values = [];


    /**
     * @param int $times Number of times this request has to be passed through routers.
     * This will not have effect if specific server is chosen
     * @return $this
     */
    public function bounce(int $times): Router
    {
        $this->values['bounce.times'] = $times;
        return $this;
    }

    /**
     * @param string $geoLocation Server continent.country location, example: africa.nigeria
     * @param string|bool|null $fallback A server to use when the specified one is not available
     * @param bool $waitForAvailability Wait for server to become available
     * @return Router
     */
    public function serverLocation(string $geoLocation, $fallback = null, bool $waitForAvailability = true): Router
    {
        $this->values['geo.location'] = $geoLocation;
        $this->values['geo.fallback'] = $fallback;
        $this->values['geo.waitForAvailability'] = $waitForAvailability;
        return $this;
    }

    /**
     * Specify which server to be connected to
     * @param string $hostAddress a server host address, example http://localhost:9100
     * @return $this
     */
    public function serverHost(string $hostAddress): Router
    {
        $this->values['host'] = $hostAddress;
        return $this;
    }

    public function getValues(): array
    {
        return $this->values;
    }
}