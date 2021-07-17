<?php

namespace Sinnrrr\Diia\Resources;

/**
 * Class Acquirer
 * @package Sinnrrr\Diia\Resources
 */
class Acquirer extends Resource
{
    /**
     * @var string
     */
    public string $_id;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var string|null
     */
    public ?string $email;

    /**
     * @var string
     */
    public string $customFullName;

    /**
     * @var string
     */
    public string $customFullAddress;

    /**
     * @var string
     */
    public string $region;

    /**
     * @var string
     */
    public string $district;

    /**
     * @var string
     */
    public string $location;

    /**
     * @var string
     */
    public string $street;

    /**
     * @var string
     */
    public string $house;

    /**
     * @var Scope
     */
    public Scope $scopes;

    /**
     * @var string
     */
    public string $offerRequestType;

    /**
     * @var array
     */
    public array $deliveryTypes;
}
