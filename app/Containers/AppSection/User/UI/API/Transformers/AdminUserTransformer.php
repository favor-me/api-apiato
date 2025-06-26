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

namespace AppSection\User\UI\API\Transformers;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\UI\API\Transformers\UserTransformer;

class AdminUserTransformer extends UserTransformer
{
    public function transform(User $user): array
    {
        return parent::transform($user) +
            [
                $this->realKey(ID) => $user->id,
                $this->realKey('country_id') => $user->country_id,
                $this->realKey('region_id') => $user->region_id,
                $this->realKey('city_id') => $user->city_id,
                'is_admin' => $user->is_admin
            ];
    }
}
