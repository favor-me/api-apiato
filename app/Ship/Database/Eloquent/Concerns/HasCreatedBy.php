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

trait HasCreatedBy
{
    public function getCreatedByColumn(): string
    {
        return CREATED_BY;
    }

    public function setCreatedBy($value): self
    {
        $this->{$this->getCreatedByColumn()} = $value;
        return $this;
    }

    public function updateCreatedBy(): void
    {
        if ($this->canDoCreatedBy()) {
            $this->setCreatedBy(Auth::user()->id);
        }
    }

    protected function canDoCreatedBy(): bool
    {
        $createdByColumn = $this->getCreatedByColumn();
        return !$this->exists && !$this->isDirty($createdByColumn) && Auth::user() instanceof User;
    }
}
