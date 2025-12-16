<?php

/**
 * FavorMe system
 *
 * This file is part of the FavorMe system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license https://favor-me.ru/licenses/erp Proprietary license
 * @copyright Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link https://kalistratov.ru
 * @author Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Containers\CommunitySection\Organization\UI\API\Transformers;

use App\Containers\AppSection\User\UI\API\Transformers\UserTransformer;
use App\Containers\CommunitySection\Organization\Foundation\Organization;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\OrganizationBranch\UI\API\Transformers\OrganizationBranchTransformer;
use App\Containers\OrganizationSection\OwnershipType\Type;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Primitive;
use ReflectionException;

class OrganizationTransformer extends Transformer
{
    protected array $availableIncludes = [
        Organization::INCLUDE_USER_OWNER,
        Organization::INCLUDE_USERS,
        Organization::INCLUDE_BRANCHES,
        Organization::BANK_DATA_SCHEMA
    ];

    public function transform(OrganizationModel $organization): array
    {
        return [
            OBJECT => $organization->getResourceKey(),
            ID => $organization->getHashedKey(),
            Organization::USER_OWNER_ID => $organization->getHashedKey(Organization::USER_OWNER_ID),
            Organization::NAME => $organization->name,
            Organization::PHONE_NUMBER => $organization->phone_number,
            Organization::EMAIL => $organization->email,
            PARAMS => $organization->params,
            Organization::BANK_DATA => $organization->bank_data,
            Organization::COUNTRY => $organization->country->toArray(),
            Organization::OWNERSHIP_TYPE => $this->getOwnershipType($organization),
            CREATED_AT => $this->nullOrTimestamp($organization->created_at),
            UPDATED_AT => $this->nullOrTimestamp($organization->updated_at),
            DELETED_AT => $this->nullOrTimestamp($organization->deleted_at)
        ];
    }

    /**
     * @param OrganizationModel $organization
     * @return Primitive
     * @throws ReflectionException
     */
    protected function includeBankDataSchema(OrganizationModel $organization): Primitive
    {
        return $this->primitive(
            $organization->country
                ->getBankDataSchema($organization->bank_data)
                ->toSchema()
        );
    }

    protected function includeUserOwner(OrganizationModel $organization): Item
    {
        return $this->item($organization->userOwner, new UserTransformer());
    }

    protected function includeUsers(OrganizationModel $organization): Collection
    {
        return $this->collection($organization->users, new UserTransformer());
    }

    protected function includeBranches(OrganizationModel $organization): Collection
    {
        return $this->collection($organization->branches, new OrganizationBranchTransformer());
    }

    private function getOwnershipType(OrganizationModel $organization): ?array
    {
        return $organization->ownership_type instanceof Type ? $organization->ownership_type->toArray() : null;
    }
}
