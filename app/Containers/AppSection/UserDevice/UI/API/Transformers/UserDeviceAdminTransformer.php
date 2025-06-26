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

namespace App\Containers\AppSection\UserDevice\UI\API\Transformers;

use App\Containers\AppSection\User\Foundation\User as BaseUser;
use App\Containers\AppSection\UserDevice\Models\UserDevice;

class UserDeviceAdminTransformer extends UserDeviceTransformer
{
    public function transform(UserDevice $userDevice): array
    {
        return parent::transform($userDevice) +
            [
                $this->realKey(ID) => $userDevice->id,
                $this->realKey(BaseUser::ID) => $userDevice->user_id
            ];
    }
}
