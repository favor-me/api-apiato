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

use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule as ValidationRuleContract;
use JBZoo\Data\JSON;

abstract class ValidationRule implements DataAwareRule, ValidationRuleContract
{
    protected ?JSON $data;

    public function setData(array $data): void
    {
        $this->data = new JSON($data);
    }
}
