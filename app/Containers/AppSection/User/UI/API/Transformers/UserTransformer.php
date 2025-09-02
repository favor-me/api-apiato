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

use App\Containers\AppSection\Authorization\UI\API\Transformers\RoleTransformer;
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\AppSection\UserDevice\UI\API\Transformers\UserDeviceTransformer;
use App\Containers\CommunitySection\Organization\UI\API\Transformers\OrganizationTransformer;
use App\Containers\CommunitySection\OrganizationBranch\UI\API\Transformers\OrganizationBranchTransformer;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Primitive;

class UserTransformer extends Transformer
{
    protected array $availableIncludes = [
        'roles',
        'devices',
        'organization',
        'organizationBranch'
    ];

    public function transform(UserModel $user): array
    {
        return [
            OBJECT => $user->getResourceKey(),
            ID => $user->getHashedKey(),
            'number' => $user->getNumber(),
            'login' => $user->login,
            'name' => $user->name,
            'patronymic' => $user->patronymic,
            'surname' => $user->surname,
            'gender' => $user->gender,
            'birth' => $this->nullOrTimestamp($user->birth),
            'avatar' => $user->avatar,
            'email' => $user->email,
            'phone_number' => $user->phone_number,
            User::IS_ORGANIZATION_OWNER => $user->is_organization_owner,
            PARAMS => $user->params,
            'email_verified_at' => $this->nullOrTimestamp($user->email_verified_at),
            'phone_number_verified_at' => $user->phone_number_verified_at,
            User::ORGANIZATION_ID => $user->getHashedKey(User::ORGANIZATION_ID),
            User::ORGANIZATION_BRANCH_ID => $user->getHashedKey(User::ORGANIZATION_BRANCH_ID),
            CREATED_AT => $user->created_at->getTimestamp(),
            UPDATED_AT => $user->updated_at->getTimestamp(),
            DELETED_AT => $this->nullOrTime($user->deleted_at)
        ];
    }

    protected function includeRoles(UserModel $user): Collection
    {
        return $this->collection($user->roles, new RoleTransformer());
    }

    protected function includeOrganization(UserModel $user): Item|Primitive
    {
        return $this->primitiveNullOrItem($user->organization, new OrganizationTransformer());
    }

    protected function includeOrganizationBranch(UserModel $user): Item|Primitive
    {
        return $this->primitiveNullOrItem($user->organizationBranch, new OrganizationBranchTransformer());
    }

    protected function includeDevices(UserModel $user): Collection
    {
        return $this->collection($user->devices(), new UserDeviceTransformer());
    }
}
