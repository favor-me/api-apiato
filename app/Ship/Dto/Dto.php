<?php

/**
 * Beauty application system
 *
 * This file is part of the Beauty application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     Proprietary
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved.
 * @link        https://kalistratov.ru
 */

namespace App\Ship\Dto;

use Illuminate\Contracts\Support\Arrayable;
use Spatie\DataTransferObject\Arr;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Spatie\DataTransferObject\Reflection\DataTransferObjectClass;

/**
 * @method  Dto except(string ...$keys)
 */
abstract class Dto extends DataTransferObject
{
    protected array $args = [];

    /**
     * @inheritDoc
     * @throws UnknownProperties
     */
    public function __construct(...$args)
    {
        parent::__construct(...$args);

        if (is_array($args[0] ?? null)) {
            $args = $args[0];
        }

        $this->args = (array) $args;
    }

    public function exists($offset): bool
    {
        return array_key_exists($offset, $this->toArray()) && property_exists($this, $offset);
    }

    public function get($offset)
    {
        if ($this->exists($offset)) {
            return $this->$offset;
        }

        return null;
    }

    public function set($offset, $value): self
    {
        $class = new DataTransferObjectClass($this);

        foreach ($class->getProperties() as $property) {
            if ($property->name === $offset) {
                $property->setValue($value);
                $this->args[$property->name] = $value;
                break;
            }
        }

        return $this;
    }

    public function toArray($intersect = false): array
    {
        $all = $array = $this->all();

        if ($intersect === true) {
            $array = array_intersect_key($all, $this->args);
        }

        if (count($this->onlyKeys)) {
            $array = Arr::only($array, $this->onlyKeys);
        } else {
            $array = Arr::except($array, $this->exceptKeys);
        }

        return $this->parseArray($array);
    }

    protected function parseArray(array $array): array
    {
        foreach ($array as $key => $value) {
            if ($value instanceof DataTransferObject || $value instanceof Arrayable) {
                $array[$key] = $value->toArray();

                continue;
            }

            if (! is_array($value)) {
                continue;
            }

            $array[$key] = $this->parseArray($value);
        }

        return $array;
    }
}
