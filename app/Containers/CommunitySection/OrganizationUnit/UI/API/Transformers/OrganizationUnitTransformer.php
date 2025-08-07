<?php

/**
 * __PROJECT_NAME__
 *
 * This file is part of the __PROJECT_NAME__ package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license __PROJECT_LICENCE__
 * @copyright Copyright (C) __PROJECT_AUTHOR__, All rights reserved ©.
 * @link __PROJECT_URL__
 * @author __PROJECT_AUTHOR__ <__PROJECT_AUTHOR__EMAIL__>
 */

namespace App\Containers\CommunitySection\OrganizationUnit\UI\API\Transformers;

use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Ship\Parents\Transformers\Transformer;

class OrganizationUnitTransformer extends Transformer
{
    public function transform(OrganizationUnitModel $organizationUnit): array
    {
        return [
            OBJECT => $organizationUnit->getResourceKey(),
            ID => $organizationUnit->getHashedKey(),
            OrganizationUnit::NAME => $organizationUnit->name,
            OrganizationUnit::TYPE => $organizationUnit->type,
            OrganizationUnit::SKU => $organizationUnit->sku,
            OrganizationUnit::ORDERING => $organizationUnit->ordering,
            PARAMS => $organizationUnit->params,
            OrganizationUnit::COST_PRICE => $organizationUnit->cost_price,
            OrganizationUnit::PRICE_UP => $organizationUnit->price_up,
            OrganizationUnit::CLIENT_PRICE => $organizationUnit->client_price,
            OrganizationUnit::BALANCE => $organizationUnit->balance,
            OrganizationUnit::ORGANIZATION_ID => $organizationUnit->getHashedKey(OrganizationUnit::ORGANIZATION_ID),
            OrganizationUnit::SYSTEM_UNIT_ID => $organizationUnit->getHashedKey(OrganizationUnit::SYSTEM_UNIT_ID),
            CREATED_AT => $this->nullOrTimestamp($organizationUnit->created_at),
            UPDATED_AT => $this->nullOrTimestamp($organizationUnit->updated_at),
            DELETED_AT => $this->nullOrTimestamp($organizationUnit->deleted_at)
        ];
    }
}
