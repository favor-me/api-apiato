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

namespace App\Containers\AppSection\Authentication\Tasks;

use Illuminate\Support\Arr;
use App\Ship\Parents\Tasks\Task;

/**
 * Class ExtractLoginCustomAttributeTask
 *
 * @package App\Containers\AppSection\Authentication\Tasks
 */
class ExtractLoginCustomAttributeTask extends Task
{
    /**
     * Run action.
     *
     * @param   array $data
     *
     * @return  array
     */
    public function run(array $data): array
    {
        $prefix = config('appSection-authentication.login.prefix', '');
        $allowedLoginFields = config('appSection-authentication.login.attributes');
        if (!$allowedLoginFields) {
            $allowedLoginFields = ['email' => []];
        }

        $fields = array_keys($allowedLoginFields);
        $loginUsername = null;
        // The original attribute that which the user tried to log in witch
        // eg 'email', 'name', 'phone'
        $loginAttribute = null;

        // Find first login custom attribute (allowed login field) found in request
        // eg: search the request exactly in order which they are in 'authentication-container'
        // for 'email' then 'phone' then 'name' in request
        // and put the first one found in 'username' field witch its value as 'username' value
        foreach ($fields as $field) {
            $fieldName = $prefix . $field;
            $loginUsername = Arr::get($data, $fieldName);
            $loginAttribute = $field;

            if ($loginUsername !== null) {
                break;
            }
        }

        return [
            'username' => $loginUsername,
            'loginAttribute' => $loginAttribute,
        ];
    }
}
