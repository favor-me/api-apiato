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

use App\Ship\Validation\ValidationRule;
use Closure;

class Time extends ValidationRule
{
    public const PATTERN = '/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/';

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match(self::PATTERN, $value)) {
            $fail(__('validation.time'));
        }
    }
}
