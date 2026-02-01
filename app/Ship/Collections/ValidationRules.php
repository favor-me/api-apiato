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

namespace App\Ship\Collections;

use Illuminate\Support\Collection;

class ValidationRules extends Collection
{
    public const REQUIRED = 'required';
    public const UNIQUE = 'unique';

    public function addIgnoreIdForUnique(int $id): self
    {
        return $this->map(function ($rule) use ($id) {
            if ($this->isUniqueRule($rule)) {
                $rule = rtrim($rule, ',');
                return $rule . ',' . $id;
            }

            return $rule;
        });
    }

    public function addRequired(): self
    {
        if (!$this->contains(self::REQUIRED)) {
            array_unshift($this->items, self::REQUIRED);
        }

        return $this;
    }

    public function isUniqueRule(mixed $rule): false|int
    {
        if (is_string($rule)) {
            return preg_match('/^' . self::UNIQUE . ':/', $rule);
        }

        return false;
    }

    public function removeRequired(): self
    {
        return $this->filter(function ($rule) {
            return $rule !== self::REQUIRED;
        });
    }

    public function removeUnique(): self
    {
        return $this->filter(function ($rule) {
            if (is_string($rule)) {
                return !preg_match('/^' . self::UNIQUE . '/', $rule);
            }

            return true;
        });
    }
}
