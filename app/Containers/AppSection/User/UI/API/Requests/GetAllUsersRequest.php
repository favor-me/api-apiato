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

namespace App\Containers\AppSection\User\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\User\Requests\UserApiRequest;

class GetAllUsersRequest extends UserApiRequest
{
    protected array $access = [
        'roles' => Role::ADMIN,
        'permissions' => 'list-users'
    ];
}
