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

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Tasks\DeleteUserTask;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Actions\Action;

class DeleteUserAction extends Action
{
    /**
     * @param array $ids
     * @return int|null
     * @throws DeleteResourceFailedException
     */
    public function run(array $ids): ?int
    {
        return app(DeleteUserTask::class)->run($ids);
    }
}
