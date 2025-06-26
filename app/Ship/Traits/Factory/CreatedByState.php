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

namespace App\Ship\Traits\Factory;

use App\Containers\AppSection\User\Models\User;

trait CreatedByState
{
    public function createdBy(mixed $user): self
    {
        $createdBy = $user instanceof User ? $user->id : $user;

        return $this->state(function () use ($createdBy) {
            return [
                CREATED_BY => $createdBy
            ];
        });
    }
}
