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

use App\Ship\Collections\ValidationRules;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Enumerable;

if (!function_exists('is_hash_id_mode')) {

    function is_hash_id_mode(): bool
    {
        return (bool)config('apiato.hash-id');
    }

}

if (!function_exists('hash_encode')) {

    function hash_encode($value): string
    {
        return is_hash_id_mode() ? Hashids::encode($value) : $value;
    }

}

if (!function_exists('hash_decode')) {

    function hash_decode($value)
    {
        if (is_hash_id_mode()) {
            $decodeValue = Hashids::decode($value);
            if (isset($decodeValue[0])) {
                return $decodeValue[0];
            }
        }

        return $value;
    }

}

if (!function_exists('validation_rules')) {

    function validation_rules(array $rules): ValidationRules
    {
        return new ValidationRules($rules);
    }

}

if (!function_exists('to_array')) {

    function to_array(mixed $items): array
    {
        if (is_array($items)) {
            return $items;
        } elseif ($items instanceof Enumerable) {
            return $items->all();
        } elseif ($items instanceof Arrayable) {
            return $items->toArray();
        } elseif ($items instanceof Jsonable) {
            return json_decode($items->toJson(), true);
        } elseif ($items instanceof JsonSerializable) {
            return (array)$items->jsonSerialize();
        } elseif ($items instanceof Traversable) {
            return iterator_to_array($items);
        } elseif ($items instanceof UnitEnum) {
            return [$items];
        }

        return (array)$items;
    }

}
