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

namespace App\Containers\CommunitySection\OrganizationUnit\UI\API\Transformers;

use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\HistorySection\ModelNote\UI\API\Transformers\ModelNoteTransformer;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\Vendor\Unit\UI\API\Transformers\UnitTransformer;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class OrganizationUnitTransformer extends Transformer
{
    protected array $defaultIncludes = [
        OrganizationUnit::SYSTEM_UNIT
    ];

    protected array $availableIncludes = [
        OrganizationUnit::MODEL_NOTES
    ];

    public function transform(OrganizationUnitModel $organizationUnit): array
    {
        $response = [
            OBJECT => $organizationUnit->getResourceKey(),
            ID => $organizationUnit->getHashedKey(),
            OrganizationUnitModel::NUMBER => $organizationUnit->getNumber(),
            OrganizationUnit::NAME => $organizationUnit->name,
            OrganizationUnit::TYPE => $organizationUnit->type->toArray(),
            OrganizationUnit::SKU => $organizationUnit->sku,
            OrganizationUnit::ORDERING => $organizationUnit->ordering,
            PARAMS => $organizationUnit->params,
            UnitPrice::COST_PRICE => $this->money($organizationUnit->cost_price),
            UnitPrice::PRICE_UP => $organizationUnit->price_up,
            UnitPrice::CLIENT_PRICE => $this->money($organizationUnit->client_price),
            UnitPrice::BALANCE => (float)$organizationUnit->balance,
            UnitPrice::IS_INFINITY_BALANCE => $organizationUnit->is_infinity_balance,
            OrganizationUnit::PRIORITY_FROM => $organizationUnit->getAttribute(OrganizationUnit::PRIORITY_FROM),
            OrganizationUnit::PRIORITY_COST_PRICE => $this->money($organizationUnit
                ->getAttribute(OrganizationUnit::PRIORITY_COST_PRICE)),
            OrganizationUnit::PRIORITY_PRICE_UP => $organizationUnit
                ->getAttribute(OrganizationUnit::PRIORITY_PRICE_UP),
            OrganizationUnit::PRIORITY_CLIENT_PRICE => $this->money($organizationUnit
                ->getAttribute(OrganizationUnit::PRIORITY_CLIENT_PRICE)),
            OrganizationUnit::PRIORITY_BALANCE => $organizationUnit
                ->getAttribute(OrganizationUnit::PRIORITY_BALANCE),
            OrganizationUnit::PRIORITY_IS_INFINITY_BALANCE => $organizationUnit
                ->getAttribute(OrganizationUnit::PRIORITY_IS_INFINITY_BALANCE),
            OrganizationUnit::ORGANIZATION_ID => $organizationUnit->getHashedKey(OrganizationUnit::ORGANIZATION_ID),
            OrganizationUnit::SYSTEM_UNIT_ID => $organizationUnit->getHashedKey(OrganizationUnit::SYSTEM_UNIT_ID),
            CREATED_AT => $this->time($organizationUnit->created_at),
            UPDATED_AT => $this->time($organizationUnit->updated_at),
            DELETED_AT => $this->time($organizationUnit->deleted_at)
        ];

        return $response;
    }

    protected function includeSystemUnit(OrganizationUnitModel $organizationUnit): Item
    {
        return $this->item($organizationUnit->systemUnit, new UnitTransformer());
    }

    protected function includeModelNotes(OrganizationUnitModel $organizationUnit): Collection
    {
        return $this->collection($organizationUnit->modelNotes, new ModelNoteTransformer());
    }
}
