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

namespace App\Ship\Validation;

use Illuminate\Validation\Rule as BaseRule;
use App\Ship\Collections\ValidationRules;

class Rule extends BaseRule
{
    public static function confirmed(): ValidationRules
    {
        return validation_rules([
            'boolean'
        ]);
    }
}
