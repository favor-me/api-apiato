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

namespace App\Containers\AppSection\User\Data\Repositories;

use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Ship\Parents\Repositories\Repository;

/**
 * @method UserModel update(array $attributes, $id)
 */
class UserRepository extends Repository
{
    protected $fieldSearchable = [
        ID => '=',
        User::EMAIL => '=',
        User::EMAIL_VERIFIED_AT => '=',
        User::NAME => 'like',
        User::ORGANIZATION_BRANCH_ID => '=',
        CREATED_AT => 'like'
    ];

    public function model(): string
    {
        return config('auth.providers.users.model');
    }

    public function getSuperUser(array $columns = ['*']): ?UserModel
    {
        $result = $this->findWhere([
            [User::EMAIL, '=', config('appSection-user.super-admin-email')]
        ], $columns);

        return $result->first();
    }
}
