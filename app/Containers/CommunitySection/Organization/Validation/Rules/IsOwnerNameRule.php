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

namespace App\Containers\CommunitySection\Organization\Validation\Rules;

use App\Containers\CommunitySection\Organization\Facades\Container;
use App\Ship\Validation\ValidationRule;
use Closure;

class IsOwnerNameRule extends ValidationRule
{
    public const string SEPARATOR = '|';
    public const int TOTAL_DETAILS = 3;

    /**
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $details = explode(self::SEPARATOR, $value);
        if (count($details) < self::TOTAL_DETAILS) {
            $fail(Container::trans('validation.is_owner_name'));
        }
    }
}
