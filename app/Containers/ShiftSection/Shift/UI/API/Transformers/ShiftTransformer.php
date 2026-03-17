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

namespace App\Containers\ShiftSection\Shift\UI\API\Transformers;

use App\Containers\AppSection\User\UI\API\Transformers\UserTransformerManager;
use App\Containers\CommunitySection\Organization\UI\API\Transformers\OrganizationTransformerManager;
use App\Containers\CommunitySection\OrganizationBranch\UI\API\Transformers\OrganizationBranchTransformerManager;
use App\Containers\ShiftSection\Item\UI\API\Transformers\ItemTransformerManager;
use App\Containers\ShiftSection\Shift\Foundation\Shift;
use App\Containers\ShiftSection\Shift\Models\Shift as ShiftModel;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Primitive;

class ShiftTransformer extends Transformer
{
    protected array $availableIncludes = [
        Shift::ITEMS,
        Shift::CREATOR,
        Shift::ORGANIZATION,
        Shift::ORGANIZATION_BRANCH
    ];

    public function transform(ShiftModel $shift): array
    {
        return [
            OBJECT => $shift->getResourceKey(),
            ID => $shift->getHashedKey(),
            Shift::ORGANIZATION_ID => $shift->getHashedKey(Shift::ORGANIZATION_ID),
            Shift::ORGANIZATION_BRANCH_ID => $shift->getHashedKey(Shift::ORGANIZATION_BRANCH_ID),
            Shift::MONEY => $this->money($shift->money),
            Shift::START_AT => $this->nullOrTimeObject($shift->start_at),
            Shift::FINISH_AT => $this->nullOrTimeObject($shift->finish_at),
            Shift::STATUS => $shift->status->toArray(),
            self::DATE_DIFF => $shift->start_at->diff($shift->finish_at),
            Shift::CONFIRMED_BY => $shift->getHashedKey(Shift::CONFIRMED_BY),
            CREATED_BY => $shift->getHashedKey(CREATED_BY),
            Shift::CONFIRMED_AT => $this->nullOrTimeObject($shift->confirmed_at),
            Shift::PAYMENT_AT => $this->nullOrTimeObject($shift->payment_at),
            CREATED_AT => $this->nullOrTimeObject($shift->created_at),
            UPDATED_AT => $this->nullOrTimeObject($shift->updated_at)
        ];
    }

    protected function includeItems(ShiftModel $shift): Collection
    {
        return $this->collection($shift->items, (new ItemTransformerManager())->getDefaultOrAdmin());
    }

    protected function includeCreator(ShiftModel $shift): Item
    {
        return $this->item($shift->creator, (new UserTransformerManager())->getDefaultOrAdmin());
    }

    protected function includeOrganization(ShiftModel $shift): Item
    {
        return $this->item($shift->organization, (new OrganizationTransformerManager())->getDefaultOrAdmin());
    }

    protected function includeOrganizationBranch(ShiftModel $shift): Item|Primitive
    {
        return $this->primitiveNullOrItem(
            $shift->organizationBranch,
            (new OrganizationBranchTransformerManager())->getDefaultOrAdmin()
        );
    }
}
