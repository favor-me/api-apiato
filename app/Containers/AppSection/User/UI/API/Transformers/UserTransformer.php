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
use App\Containers\CommunitySection\Organization\UI\API\Transformers\OrganizationTransformerManager;
use App\Containers\CommunitySection\OrganizationBranch\UI\API\Transformers\OrganizationBranchTransformerManager;
use App\Containers\OrganizationSection\Shift\UI\API\Transformers\ShiftTransformerManager;
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
        'organizationBranch',
        User::TODAY_SHIFT
    ];

    public function transform(UserModel $user): array
    {
        return [
            OBJECT => $user->getResourceKey(),
            ID => $user->getHashedKey(),
            UserModel::NUMBER => $user->getNumber(),
            User::LOGIN => $user->login,
            User::NAME => $user->name,
            User::PATRONYMIC => $user->patronymic,
            User::SURNAME => $user->surname,
            User::GENDER => $user->gender,
            User::BIRTH => $this->nullOrTimestamp($user->birth),
            User::AVATAR => $user->avatar,
            User::EMAIL => $user->email,
            User::PHONE_NUMBER => $user->phone_number,
            User::IS_ORGANIZATION_OWNER => $user->is_organization_owner,
            PARAMS => $user->params,
            User::EMAIL_VERIFIED_AT => $this->nullOrTimestamp($user->email_verified_at),
            User::PHONE_NUMBER_VERIFIED_AT => $user->phone_number_verified_at,
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
        return $this->primitiveNullOrItem(
            $user->organization,
            (new OrganizationTransformerManager())->getDefaultOrAdmin()
        );
    }

    protected function includeOrganizationBranch(UserModel $user): Item|Primitive
    {
        return $this->primitiveNullOrItem(
            $user->organizationBranch,
            (new OrganizationBranchTransformerManager())->getDefaultOrAdmin()
        );
    }

    protected function includeDevices(UserModel $user): Collection
    {
        return $this->collection($user->devices(), new UserDeviceTransformer());
    }

    protected function includeTodayShift(UserModel $user): Item|Primitive
    {
        return $this->primitiveNullOrItem(
            $user->todayShift,
            (new ShiftTransformerManager())->getDefaultOrAdmin()
        );
    }
}
