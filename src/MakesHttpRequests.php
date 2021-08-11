<?php

namespace Sinnrrr\Diia;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Trait MakesHttpRequests
 * @package Sinnrrr\Diia
 */
trait MakesHttpRequests
{
    /**
     * Guzzle default options config array.
     *
     * @var array
     */
    private array $guzzleDefaultOptions = [
        'http_errors' => false,
        'headers' => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ]
    ];

    /**
     * Guzzle current options config array.
     *
     * @var array
     */
    private array $guzzleCurrentOptions;

    /**
     * Diia URI for testing purposes.
     *
     * @var string
     */
    private string $diiaTestingUrl = "https://api2s.diia.gov.ua/";

    /**
     * Diia URI for production use.
     *
     * @var string
     */
    private string $diiaProductionUrl = "https://api2.diia.gov.ua/";


    /**
     * Parameter, which defines class actions mode.
     *
     * @var bool
     */
    private bool $testingMode = false;

    /**
     * A method, which sets the testing mode to be true.
     *
     * @return void
     */
    public function setTestingMode(): void
    {
        $this->testingMode = true;
        $this->guzzleCurrentOptions = array_merge(
            $this->guzzleDefaultOptions,
            ['base_uri' => $this->diiaTestingUrl]
        );

        $this->guzzle = new HttpClient($this->guzzleCurrentOptions);
    }

    /**
     * A method, which sets the testing mode to be false.
     *
     * @return void
     */
    public function setProductionMode(): void
    {
        $this->testingMode = false;
        $this->guzzleCurrentOptions = array_merge(
            $this->guzzleDefaultOptions,
            ['base_uri' => $this->diiaProductionUrl]
        );

        $this->guzzle = new HttpClient($this->guzzleCurrentOptions);
    }

    private function setDefaultHeaders(array $headers): void
    {
        $this->guzzleCurrentOptions = array_merge(
            $this->guzzleCurrentOptions,
            ['headers' => $headers]
        );

        $this->guzzle = new HttpClient($this->guzzleCurrentOptions);
    }

    /**
     * A method, which returns current mode.
     *
     * @return string
     */
    public function getMode(): string
    {
        return $this->testingMode ? 'testing' : 'production';
    }

    /**
     * Guzzle instance for making HTTP requests
     * made public to allow developer to set it's own one.
     *
     * @var HttpClient
     */
    public HttpClient $guzzle;

    /**
     * @param string $uri
     * @return array|string
     */
    public function get(string $uri): array|string
    {
        return $this->request('GET', $uri);
    }

    /**
     * @param string $uri
     * @param array $payload
     * @return array|string
     */
    public function post(string $uri, array $payload = []): array|string
    {
        return $this->request('POST', $uri, $payload);
    }

    /**
     * @param string $uri
     * @param array $payload
     * @return array|string
     */
    public function put(string $uri, array $payload = []): array|string
    {
        return $this->request('PUT', $uri, $payload);
    }

    /**
     * @param string $uri
     * @return string
     */
    public function delete(string $uri): string
    {
        return $this->request('DELETE', $uri);
    }

    /**
     * Helper method to make reliable HTTP requests.
     *
     * @param string $method
     * @param string $uri
     * @param array $payload
     * @return array|string
     */
    protected function request(string $method, string $uri, array $payload = []): array|string
    {
        try {
            $response = $this->guzzle->request($method, $uri, $payload);
            $responseBody = (string)$response->getBody();

            return json_decode($responseBody, true) ?: $responseBody;
        } catch (GuzzleException $exception) {
            printf($exception);
            // TODO: exceptions
            // TODO: if one of the tokens missing - auto get it
        }
    }
}
