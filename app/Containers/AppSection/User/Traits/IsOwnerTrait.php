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

namespace App\Containers\AppSection\User\Traits;

use App\Containers\AppSection\Authentication\Tasks\GetAuthenticatedUserTask;

/**
 * @property mixed $id
 */
trait IsOwnerTrait
{
    public function isOwner(): bool
    {
        $user = app(GetAuthenticatedUserTask::class)->run();
        return $user->id === $this->id;
    }
}
