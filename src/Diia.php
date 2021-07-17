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
        Actions\ObtainsSessionToken,
        Actions\ManagesAcquirers;

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

        // Obtain session token, using acquirer token
        $this->sessionToken = $this->obtainSessionToken($this->acquirerToken);

        // If there were no guzzle instance provided, make the default one
        if (is_null($guzzle)) {
            $this->guzzle = new HttpClient([
                'base_uri' => 'https://api2.diia.gov.ua/api/v1/',
                'http_errors' => false,
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ]
            ]);
        }
    }
}
