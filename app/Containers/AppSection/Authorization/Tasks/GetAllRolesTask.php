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

namespace App\Containers\AppSection\Authorization\Tasks;

use App\Ship\Parents\Tasks\Task;
use App\Containers\AppSection\Authorization\Data\Repositories\RoleRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class GetAllRolesTask extends Task
{
    public function __construct(
        protected RoleRepository $repository
    ) {
    }

    public function run(): LengthAwarePaginator
    {
        return $this->repository->paginate();
    }
}
