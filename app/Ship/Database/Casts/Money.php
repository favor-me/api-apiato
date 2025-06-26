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

namespace App\Ship\Database\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use App\Ship\SimpleTypes\Type\Money as MoneyType;
use Illuminate\Contracts\Database\Eloquent\SerializesCastableAttributes;

class Money implements CastsAttributes, SerializesCastableAttributes
{
    /**
     * @inheritDoc
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return app('money')->add($value);
    }

    /**
     * @inheritDoc
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if ($value instanceof MoneyType) {
            $value = $value->val();
        }

        return (int)$value;
    }

    /**
     * @inheritDoc
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function serialize($model, string $key, $value, array $attributes)
    {
        if ($value instanceof MoneyType) {
            return (int)$value->val();
        }

        return (int)$value;
    }
}
