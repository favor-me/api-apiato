<?php

/**
 * FavorMe system
 *
 * This file is part of the FavorMe system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license https://favor-me.ru/licenses/erp Proprietary license
 * @copyright Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link https://kalistratov.ru
 * @author Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Ship\Collections;

use App\Ship\Validation\Rule;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rules\Unique;

class ValidationRules extends Collection
{
    public function addIgnoreIdForUnique(int $id): self
    {
        return $this->map(function ($rule) use ($id) {
            if ($this->isUniqueRule($rule)) {
                if (is_string($rule)) {
                    return rtrim($rule, ',') . ',' . $id;
                } elseif ($rule instanceof Unique) {
                    return $rule->ignore($id);
                }
            }

            return $rule;
        });
    }

    public function addRequired(): self
    {
        if (!$this->contains(Rule::REQUIRED)) {
            array_unshift($this->items, Rule::REQUIRED);
        }

        return $this;
    }

    public function isUniqueRule(mixed $rule): false|int
    {
        if ($rule instanceof Unique) {
            return true;
        }

        if (is_string($rule)) {
            return preg_match('/^' . Rule::UNIQUE . ':/', $rule);
        }

        return false;
    }

    public function removeRequired(): self
    {
        return $this->filter(function ($rule) {
            return $rule !== Rule::REQUIRED;
        });
    }

    public function removeUnique(): self
    {
        return $this->filter(function ($rule) {
            if (is_string($rule)) {
                return !preg_match('/^' . Rule::UNIQUE . '/', $rule);
            }

            return true;
        });
    }
}
