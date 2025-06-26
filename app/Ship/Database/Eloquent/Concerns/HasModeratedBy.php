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

trait HasModeratedBy
{
    public function getModeratedByColumn(): string
    {
        return 'moderated_by';
    }

    public function getModeratedFlagColumn(): string
    {
        return 'is_moderated';
    }

    public function setModeratedBy($value): self
    {
        $this->{$this->getModeratedByColumn()} = $value;
        return $this;
    }

    public function updateModeratedBy(): void
    {
        if ($this->canDoModeratedBy()) {
            $this->setModeratedBy(Auth::user()->id);
        }
    }

    protected function canDoModeratedBy(): bool
    {
        $moderatedByColumn = $this->getModeratedByColumn();
        $isModerated = $this->getAttribute($this->getModeratedFlagColumn());
        return $isModerated === true && !$this->isDirty($moderatedByColumn) && Auth::user() instanceof User;
    }
}
