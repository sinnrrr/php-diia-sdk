<?php

namespace Sinnrrr\Diia\Resources;

/**
 * Class Branch
 * @package Sinnrrr\Diia\Resources
 */
class Branch extends Resource
{
    /**
     * @var string
     */
    public string $id;

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
     * @var array
     */
    public array $scopes;

    /**
     * @var string
     */
    public string $offerRequestType;

    /**
     * @var array
     */
    public array $deliveryTypes;
}
