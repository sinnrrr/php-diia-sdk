<?php

namespace Sinnrrr\Diia;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;

/**
 * Trait MakesHttpRequests
 * @package Sinnrrr\Diia
 */
trait MakesHttpRequests
{
    /**
     * Guzzle instance for making HTTP requests
     * made public to allow developer to set it's own one.
     *
     * @var HttpClient
     */
    public HttpClient $guzzle;

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
    private string $diiaTestingUrl = "https://api2s.diia.gov.ua/api/";

    /**
     * Diia URI for production use.
     *
     * @var string
     */
    private string $diiaProductionUrl = "https://api2.diia.gov.ua/api/";

    /**
     * Method, which sets default options for guzzle client
     *
     * @param array $options
     * @return HttpClient
     */
    private function applyDefaultOptions(array $options): HttpClient
    {
        $this->guzzleCurrentOptions = array_merge_recursive($this->guzzleCurrentOptions, $options);
        $this->guzzle = new HttpClient($this->guzzleCurrentOptions);

        return $this->guzzle;
    }

    /**
     * Parameter, which defines class actions mode.
     *
     * @var bool
     */
    private bool $testingMode = false;

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
     * A method, which sets the testing mode to be true.
     *
     * @return void
     */
    public function setTestingMode(): void
    {
        $this->applyDefaultOptions(['base_uri' => $this->diiaTestingUrl]);
    }

    /**
     * A method, which sets the testing mode to be false.
     *
     * @return void
     */
    public function setProductionMode(): void
    {
        $this->applyDefaultOptions(['base_uri' => $this->diiaProductionUrl]);
    }

    /**
     * @param string $uri
     * @return array
     */
    public function get(string $uri): array
    {
        return $this->request('GET', $uri);
    }

    /**
     * @param string $uri
     * @param array $payload
     * @return array
     */
    public function post(string $uri, array $payload = []): array
    {
        return $this->request('POST', $uri, $payload);
    }

    /**
     * @param string $uri
     * @param array $payload
     * @return array
     */
    public function put(string $uri, array $payload = []): array
    {
        return $this->request('PUT', $uri, $payload);
    }

    /**
     * @param string $uri
     * @return array
     */
    public function delete(string $uri): array
    {
        return $this->request('DELETE', $uri);
    }

    /**
     * Helper method to make reliable HTTP requests.
     *
     * @param string $method
     * @param string $uri
     * @param array $payload
     * @return array
     */
    protected function request(string $method, string $uri, array $payload = []): array
    {
        $stack = HandlerStack::create();
// my middleware
        $stack->push(Middleware::mapRequest(function (RequestInterface $request) {
            $contentsRequest = (string) $request->getBody();
            var_dump($contentsRequest);

            return $request;
        }));

        try {
            return json_decode($this->guzzle->request($method, $uri, array_merge($payload, ['handler' => $stack]))->getBody(), true);
        } catch (GuzzleException $exception) {
            printf($exception);
            // TODO: exceptions
            // TODO: if one of the tokens missing - auto get it
        }
    }
}
