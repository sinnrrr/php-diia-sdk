<?php

namespace Sinnrrr\Diia\Resources;

use Sinnrrr\Diia\Diia;
use Sinnrrr\Diia\Fillable;

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

    /**
     * Transform the items of the collection to the given class.
     *
     * @param array $collection
     * @param $class
     * @param array $extraData
     * @return array
     */
    protected function transformCollection(array $collection, $class, array $extraData = []): array
    {
        return array_map(function ($data) use ($class, $extraData) {
            return new $class($data + $extraData, $this->diia);
        }, $collection);
    }
}
