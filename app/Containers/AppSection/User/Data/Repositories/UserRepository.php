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

use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Repositories\Repository;

/**
 * @method  User update(array $attributes, $id)
 */
class UserRepository extends Repository
{
    protected $fieldSearchable = [
        'id'                => '=',
        'email'             => '=',
        'email_verified_at' => '=',
        'name'              => 'like',
        'created_at'        => 'like'
    ];

    public function model(): string
    {
        return config('auth.providers.users.model');
    }

    public function getSuperUser(array $columns = ['*']): User
    {
        return $this->findWhere([
            ['email', '=', config('appSection-user.super-admin-email')]
        ], $columns)->first();
    }
}
