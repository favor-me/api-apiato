<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 */

namespace App\Containers\OrderSection\PaymentType;

use App\Containers\OrderSection\PaymentType\Facades\Container;
use App\Ship\Contracts\Namebled;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use ReflectionClass;

abstract class Type implements Namebled, Arrayable
{
    public function getName(): string
    {
        $reflectionType = new ReflectionClass(static::class);
        $name = str_replace('Type', '', $reflectionType->getShortName());
        return Str::snake($name);
    }

    public function getTitle(): string
    {
        return (string)Container::trans('container.' . $this->getName() . '.title');
    }

    public function toArray(): array
    {
        return [
            'title' => $this->getTitle(),
            'name' => $this->getName()
        ];
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
