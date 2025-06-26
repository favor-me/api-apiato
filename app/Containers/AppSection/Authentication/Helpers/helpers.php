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

use Illuminate\Support\Arr;
use App\Containers\AppSection\User\Models\User;

if (!function_exists('loginAttributeValidationRulesMerger')) {

    /**
     * Login attribute validation rules merger.
     *
     * @param   array $rules
     *
     * @return  array
     */
    function loginAttributeValidationRulesMerger(array $rules): array
    {
        $prefix = config('appSection-authentication.login.prefix', '');
        $allowedLoginAttributes = config('appSection-authentication.login.attributes', ['email' => []]);

        if (count($allowedLoginAttributes) === 1) {
            $key = array_key_first($allowedLoginAttributes);
            $optionalValidators = $allowedLoginAttributes[$key];
            $validators = implode('|', $optionalValidators);

            $fieldName = $prefix . $key;

            $rules[$fieldName] = "required:{$fieldName}|exists:users,{$key}|{$validators}";

            return $rules;
        }

        foreach ($allowedLoginAttributes as $key => $optionalValidators) {
            // build all other login fields together
            $otherLoginFields = Arr::except($allowedLoginAttributes, $key);
            $otherLoginFields = array_keys($otherLoginFields);
            $otherLoginFields = preg_filter('/^/', $prefix, $otherLoginFields);
            $otherLoginFields = implode(',', $otherLoginFields);

            $validators = implode('|', $optionalValidators);

            $fieldName = $prefix . $key;

            $rules[$fieldName] = "required_without_all:{$otherLoginFields}|exists:users,{$key}|{$validators}";
        }

        return $rules;
    }

}

if (!function_exists('is_authenticated')) {
    function is_authenticated(): bool
    {
        return auth()->user() instanceof User;
    }
}
