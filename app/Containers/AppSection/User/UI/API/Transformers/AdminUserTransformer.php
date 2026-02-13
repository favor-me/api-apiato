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

namespace App\Containers\AppSection\User\UI\API\Transformers;

use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;

final class AdminUserTransformer extends UserTransformer
{
    public function transform(UserModel $user): array
    {
        return parent::transform($user) +
            [
                User::IS_ADMIN => $user->is_admin,
                $this->realKey(ID) => $user->id,
                $this->realKey(User::ORGANIZATION_ID) => $user->organization_id,
                $this->realKey(User::ORGANIZATION_BRANCH_ID) => $user->organization_branch_id
            ];
    }
}
