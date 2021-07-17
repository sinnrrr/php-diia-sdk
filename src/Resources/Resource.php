<?php

namespace Sinnrrr\Diia\Resources;

use Sinnrrr\Diia\Diia;

class Resource
{
    /**
     * The resource attributes.
     *
     * @var array|null
     */
    public ?array $attributes;

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
     * Fill the resource with the array of attributes.
     *
     * @return void
     */
    protected function fill()
    {
        foreach ($this->attributes as $key => $value) {
            $key = $this->camelCase($key);

            $this->{$key} = $value;
        }
    }

    /**
     * Convert the key name to camel case.
     *
     * @param string $key
     * @return string
     */
    protected function camelCase(string $key): string
    {
        $parts = explode('_', $key);

        foreach ($parts as $i => $part) {
            if ($i !== 0) {
                $parts[$i] = ucfirst($part);
            }
        }

        return str_replace(' ', '', implode(' ', $parts));
    }

    /**
     * Transform the items of the collection to the given class.
     *
     * @param array $collection
     * @param string $class
     * @param array $extraData
     * @return array
     */
    protected function transformCollection(array $collection, string $class, array $extraData = []): array
    {
        return array_map(function ($data) use ($class, $extraData) {
            return new $class($data + $extraData, $this->diia);
        }, $collection);
    }
}
