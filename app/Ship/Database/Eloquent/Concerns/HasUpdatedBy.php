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

namespace App\Ship\Database\Eloquent\Concerns;

use App\Containers\AppSection\User\Models\User;
use Illuminate\Support\Facades\Auth;

trait HasUpdatedBy
{
    public function getUpdatedByColumn(): string
    {
        return UPDATED_BY;
    }

    public function setUpdatedBy($value): self
    {
        $this->{$this->getUpdatedByColumn()} = $value;
        return $this;
    }

    public function updateUpdatedBy(): void
    {
        if ($this->canDoUpdatedBy()) {
            $this->setUpdatedBy(Auth::user()->id);
        }
    }

    protected function canDoUpdatedBy(): bool
    {
        $updatedByColumn = $this->getUpdatedByColumn();
        return !$this->isDirty($updatedByColumn) && Auth::user() instanceof User;
    }
}
