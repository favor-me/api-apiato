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
use App\Containers\AppSection\User\UI\API\Transformers\UserTransformer;
use App\Containers\AppSection\UserDevice\Foundation\UserDevice as BaseUserDevice;
use App\Containers\AppSection\UserDevice\Models\UserDevice;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Item;

class UserDeviceTransformer extends Transformer
{
    public const INCLUDE_USER = 'user';

    protected array $availableIncludes = [
        self::INCLUDE_USER
    ];

    public function transform(UserDevice $userDevice): array
    {
        return [
            OBJECT => $userDevice->getResourceKey(),
            ID => $userDevice->getHashedKey(),
            BaseUser::ID => $userDevice->getHashedKey(BaseUser::ID),
            BaseUserDevice::MODEL => $userDevice->model,
            BaseUserDevice::TOKEN => $userDevice->token,
            CREATED_AT => $this->nullOrTimeObject($userDevice->created_at),
            UPDATED_AT => $this->nullOrTimeObject($userDevice->updated_at)
        ];
    }

    protected function includeUser(UserDevice $userDevice): Item
    {
        return $this->item($userDevice->user, new UserTransformer());
    }
}
