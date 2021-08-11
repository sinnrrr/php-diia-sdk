<?php

namespace Sinnrrr\Diia\Resources;

/**
 * Class Offer
 * @package Sinnrrr\Diia\Resources
 */
class Offer extends Resource
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
    public ?string $returnLink;

    /**
     * @var array
     */
    public array $scopes;
}
