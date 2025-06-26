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
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Item;

class OrganizationTransformer extends Transformer
{
    protected array $availableIncludes = [
        Organization::INCLUDE_USER_OWNER
    ];

    public function transform(OrganizationModel $organization): array
    {
        return [
            OBJECT => $organization->getResourceKey(),
            ID => $organization->getHashedKey(),
            Organization::USER_OWNER_ID => $organization->getHashedKey(Organization::USER_OWNER_ID),
            Organization::NAME => $organization->name,
            Organization::INN => $organization->inn,
            Organization::PHONE_NUMBER => $organization->phone_number,
            Organization::EMAIL => $organization->email,
            PARAMS => $organization->params,
            CREATED_AT => $this->nullOrTimestamp($organization->created_at),
            UPDATED_AT => $this->nullOrTimestamp($organization->updated_at),
            DELETED_AT => $this->nullOrTimestamp($organization->deleted_at)
        ];
    }

    protected function includeUserOwner(OrganizationModel $organization): Item
    {
        return $this->item($organization->userOwner, new UserTransformer());
    }
}
