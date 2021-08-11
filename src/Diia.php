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
     * @return Diia
     */
    public function setTestingMode(): Diia
    {
        $this->testingMode = true;
        $this->guzzle->setDefaultOption('base_uri', $this->diiaTestingUrl);

        return $this;
    }

    /**
     * A method, which sets the testing mode to be false.
     *
     * @return Diia
     */
    public function setProductionMode(): Diia
    {
        $this->testingMode = false;
        $this->guzzle->setDefaultOption('base_uri', $this->diiaProductionUrl);

        return $this;
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
            $this->guzzle = new HttpClient([
                'http_errors' => false,
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ]
            ]);

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
