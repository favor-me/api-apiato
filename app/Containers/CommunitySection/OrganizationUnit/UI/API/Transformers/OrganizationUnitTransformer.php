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
use App\Containers\Vendor\Unit\UI\API\Transformers\UnitTransformer;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Item;

class OrganizationUnitTransformer extends Transformer
{
    protected array $defaultIncludes = [
        OrganizationUnit::INCLUDE_SYSTEM_UNIT
    ];

    public function transform(OrganizationUnitModel $organizationUnit): array
    {
        return [
            OBJECT => $organizationUnit->getResourceKey(),
            ID => $organizationUnit->getHashedKey(),
            'number' => $organizationUnit->getNumber(),
            OrganizationUnit::NAME => $organizationUnit->name,
            OrganizationUnit::TYPE => $organizationUnit->type->toArray(),
            OrganizationUnit::SKU => $organizationUnit->sku,
            OrganizationUnit::ORDERING => $organizationUnit->ordering,
            PARAMS => $organizationUnit->params,
            OrganizationUnit::COST_PRICE => $this->money($organizationUnit->cost_price),
            OrganizationUnit::PRICE_UP => $organizationUnit->price_up,
            OrganizationUnit::CLIENT_PRICE => $this->money($organizationUnit->client_price),
            OrganizationUnit::BALANCE => $organizationUnit->balance,
            OrganizationUnit::IS_INFINITY_BALANCE => $organizationUnit->is_infinity_balance,
            OrganizationUnit::ORGANIZATION_ID => $organizationUnit->getHashedKey(OrganizationUnit::ORGANIZATION_ID),
            OrganizationUnit::SYSTEM_UNIT_ID => $organizationUnit->getHashedKey(OrganizationUnit::SYSTEM_UNIT_ID),
            CREATED_AT => $this->time($organizationUnit->created_at),
            UPDATED_AT => $this->time($organizationUnit->updated_at),
            DELETED_AT => $this->time($organizationUnit->deleted_at)
        ];
    }

    protected function includeSystemUnit(OrganizationUnitModel $organizationUnit): Item
    {
        return $this->item($organizationUnit->systemUnit, new UnitTransformer());
    }
}
