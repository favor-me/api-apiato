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

namespace App\Ship\Validation\Rules;

use App\Ship\Utils\Str;
use App\Ship\Validation\ValidationRule;
use Closure;

class PhoneNumber extends ValidationRule
{
    public const string REGX = '/^\d{11,14}$/';

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match(self::REGX, Str::toPhoneNumber($value))) {
            $fail(__('validation.phone.real_number'));
        }
    }
}
