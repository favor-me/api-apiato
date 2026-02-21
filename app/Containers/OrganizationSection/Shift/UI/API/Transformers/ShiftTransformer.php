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

namespace App\Containers\OrganizationSection\Shift\UI\API\Transformers;

use App\Containers\AppSection\User\UI\API\Transformers\UserTransformerManager;
use App\Containers\CommunitySection\Organization\UI\API\Transformers\OrganizationTransformerManager;
use App\Containers\CommunitySection\OrganizationBranch\UI\API\Transformers\OrganizationBranchTransformerManager;
use App\Containers\OrganizationSection\Shift\Foundation\Shift;
use App\Containers\OrganizationSection\Shift\Models\Shift as ShiftModel;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Item;

class ShiftTransformer extends Transformer
{
    protected array $availableIncludes = [
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
            Shift::START_AT => $this->time($shift->start_at),
            Shift::FINISH_AT => $this->time($shift->finish_at),
            self::DATE_DIFF => $shift->start_at->diff($shift->finish_at),
            CREATED_BY => $shift->getHashedKey(CREATED_BY),
            CREATED_AT => $this->time($shift->created_at),
            UPDATED_AT => $this->time($shift->updated_at)
        ];
    }

    protected function includeCreator(ShiftModel $shift): Item
    {
        return $this->item($shift->creator, (new UserTransformerManager())->getDefaultOrAdmin());
    }

    protected function includeOrganization(ShiftModel $shift): Item
    {
        return $this->item($shift->organization, (new OrganizationTransformerManager())->getDefaultOrAdmin());
    }

    protected function includeOrganizationBranch(ShiftModel $shift): Item
    {
        return $this->nullOrItem(
            $shift->organizationBranch,
            (new OrganizationBranchTransformerManager())->getDefaultOrAdmin()
        );
    }
}
