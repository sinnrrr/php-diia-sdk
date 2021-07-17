<?php

namespace Sinnrrr\Diia;

use GuzzleHttp\Client as HttpClient;

/**
 * Class Diia
 * @package Sinnrrr\Diia
 */
class Diia
{
    use Actions\ManagesAcquirers;

    /**
     * The acquirerToken, which you can get from the employee of Diia service.
     *
     * @var string
     */
    protected string $acquirerToken;

    /**
     * Diia constructor.
     * @param string $acquirerToken
     * @param HttpClient|null $guzzle
     */
    public function __construct(string $acquirerToken, HttpClient $guzzle = null)
    {
        $this->acquirerToken = $acquirerToken;

        // TODO: get session token

        // If there were no guzzle instance provided, make the default one
        if (is_null($guzzle)) {
            $this->guzzle = new HttpClient([
                'base_uri' => 'https://api2.diia.gov.ua/api/v2/',
                'http_errors' => false,
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ]
            ]);
        }
    }
}
