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

namespace App\Containers\AppSection\UserDevice\Data\Criterias;

use App\Containers\AppSection\UserDevice\Models\UserDevice;
use App\Containers\AppSection\User\Foundation\User as BaseUser;
use App\Containers\AppSection\UserDevice\Foundation\UserDevice as BaseUserDevice;
use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface;

final class UserDeviceCriteria extends Criteria
{
    public function __construct(
        protected int $userId,
        protected string $model,
    ) {
    }

    /**
     * @param UserDevice|Builder $model
     * @param RepositoryInterface $repository
     * @return mixed|void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model
            ->where(BaseUser::ID, $this->userId)
            ->where(BaseUserDevice::MODEL, $this->model);
    }
}
