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

namespace App\Containers\OrderSection\PaymentType\Casts;

use App\Containers\OrderSection\PaymentType\Manager;
use App\Containers\OrderSection\PaymentType\Type;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Database\Eloquent\SerializesCastableAttributes;

class PaymentType implements CastsAttributes, SerializesCastableAttributes
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return Manager::getInstance()->get($value);
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if ($value instanceof Type) {
            return $value->getName();
        }

        return $value;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function serialize($model, string $key, $value, array $attributes)
    {
        if ($value instanceof Type) {
            return $value->getName();
        }

        return $value;
    }
}
