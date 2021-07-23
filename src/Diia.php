<?php

namespace Sinnrrr\Diia;

use GuzzleHttp\Client as HttpClient;

/**
 * Class Diia
 * @package Sinnrrr\Diia
 */
class Diia
{
    use MakesHttpRequests,
        Actions\ManagesSession,
        Actions\ManagesBranches,
        Actions\ManagesOffers,
        Actions\ManagesServiceRequests;

    /**
     * Guzzle instance for making HTTP requests
     * made public to allow developer to set it's own one.
     *
     * @var HttpClient
     */
    public HttpClient $guzzle;

    /**
     * The acquirer token, which you can get from the employee of 'Diia' service.
     *
     * @var string
     */
    protected string $acquirerToken;

    /**
     * The session token, which you can get by authorizing with acquirer token.
     *
     * @var string
     */
    protected string $sessionToken;

    /**
     * Diia constructor.
     * @param string $acquirerToken
     * @param HttpClient|null $guzzle
     */
    public function __construct(string $acquirerToken, HttpClient $guzzle = null)
    {
        $this->acquirerToken = $acquirerToken;

        // If there were no guzzle instance provided, make the default one.
        if (is_null($guzzle)) {
            $this->guzzle = new HttpClient([
                'base_uri' => 'https://api2.diia.gov.ua/api/',
                'http_errors' => false,
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ]
            ]);
        } else $this->guzzle = $guzzle;

        $this->sessionToken = $this->obtainSessionToken($this->acquirerToken);
    }

    /**
     * Transform the items of the collection to the given class.
     *
     * @param array $collection
     * @param string $class
     * @param array $extraData
     * @return array
     */
    protected function transformCollection(array $collection, string $class, $extraData = []): array
    {
        return array_map(function ($data) use ($class, $extraData) {
            return new $class($data + $extraData, $this);
        }, $collection);
    }
}
