<?php

namespace Sinnrrr\Diia;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;

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
        } catch (RequestException $exception) {
            printf($exception);
            // TODO: exceptions
            // TODO: if one of the tokens missing - auto get it
        }
    }
}
