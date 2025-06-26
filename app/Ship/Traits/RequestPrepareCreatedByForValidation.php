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

namespace App\Ship\Traits;

use App\Containers\AppSection\User\Models\User;

/**
 * @property mixed $created_by
 * @method User user()
 */
trait RequestPrepareCreatedByForValidation
{
    public function getCreatedBy(): int
    {
        return (int)$this->created_by;
    }

    public function getAuthUserHashedKey(): mixed
    {
        return $this->user()->getHashedKey();
    }

    protected function mergeCreatedByFromAuthUser(): void
    {
        $this->merge([
            CREATED_BY => $this->getAuthUserHashedKey()
        ]);
    }

    protected function mergeCreatedByFromAuthUserIfInputNoExists(): void
    {
        if (!$this->has(CREATED_BY)) {
            $this->mergeCreatedByFromAuthUser();
        }
    }

    protected function prepareForValidation(): void
    {
        $this->prepareCreatedByForValidation();
    }

    protected function prepareCreatedByForValidation(): void
    {
        if ($this->user()->is_admin) {
            $this->prepareForValidationForAdmin();
        } else {
            $this->mergeCreatedByFromAuthUser();
        }
    }

    protected function prepareForValidationForAdmin(): void
    {
        $this->mergeCreatedByFromAuthUserIfInputNoExists();
    }
}
