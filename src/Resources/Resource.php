<?php

namespace Sinnrrr\Diia\Resources;

use Sinnrrr\Diia\Diia;
use Sinnrrr\Diia\Fillable;

/**
 * Class Resource
 * @package Sinnrrr\Diia\Resources
 */
class Resource
{
    use Fillable;

    /**
     * The Diia SDK instance.
     *
     * @var Diia|null
     */
    protected ?Diia $diia;

    /**
     * Create a new resource instance.
     *
     * @param array $attributes
     * @param Diia|null $diia
     * @return void
     */
    public function __construct(array $attributes, Diia $diia = null)
    {
        $this->attributes = $attributes;
        $this->diia = $diia;

        $this->fill();
    }
}
