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

namespace App\Containers\CommunitySection\OrganizationBranch\UI\API\Transformers;

use App\Containers\AppSection\User\UI\API\Transformers\UserTransformer;
use App\Containers\CommunitySection\Organization\UI\API\Transformers\OrganizationTransformer;
use App\Containers\CommunitySection\OrganizationBranch\Foundation\OrganizationBranch;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch as OrganizationBranchModel;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\NullResource;

class OrganizationBranchTransformer extends Transformer
{
    protected array $availableIncludes = [
        OrganizationBranch::INCLUDE_ORGANIZATION,
        OrganizationBranch::INCLUDE_RESPONSIBLE
    ];

    public function transform(OrganizationBranchModel $organizationBranch): array
    {
        return [
            OBJECT => $organizationBranch->getResourceKey(),
            ID => $organizationBranch->getHashedKey(),
            'number' => $organizationBranch->getNumber(),
            OrganizationBranch::NAME => $organizationBranch->name,
            OrganizationBranch::PHONE_NUMBER => $organizationBranch->phone_number,
            OrganizationBranch::LOCATION => $organizationBranch->location,
            OrganizationBranch::LATITUDE => $organizationBranch->latitude,
            OrganizationBranch::LONGITUDE => $organizationBranch->longitude,
            OrganizationBranch::ORGANIZATION_ID => $organizationBranch->getHashedKey(
                OrganizationBranch::ORGANIZATION_ID
            ),
            OrganizationBranch::RESPONSIBLE_BY => $organizationBranch->getHashedKey(OrganizationBranch::RESPONSIBLE_BY),
            CREATED_AT => $this->nullOrTimestamp($organizationBranch->created_at),
            UPDATED_AT => $this->nullOrTimestamp($organizationBranch->updated_at),
            DELETED_AT => $this->nullOrTimestamp($organizationBranch->deleted_at)
        ];
    }

    protected function includeOrganization(OrganizationBranchModel $organizationBranch): Item
    {
        return $this->item($organizationBranch->organization, new OrganizationTransformer());
    }

    protected function includeResponsible(OrganizationBranchModel $organizationBranch): Item|NullResource
    {
        return $this->nullOrItem($organizationBranch->responsible, new UserTransformer());
    }
}
