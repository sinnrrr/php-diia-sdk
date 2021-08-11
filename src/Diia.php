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
     * The acquirer token, which you can get from the employee of 'Diia' service.
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

        // If there were no guzzle instance provided, make the default one.
        if (is_null($guzzle)) {
            $this->testingMode ? $this->setTestingMode() : $this->setProductionMode();
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
