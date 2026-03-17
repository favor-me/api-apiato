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

namespace App\Containers\CommunitySection\OrganizationClient\UI\API\Transformers;

use App\Containers\CommunitySection\Organization\UI\API\Transformers\OrganizationTransformer;
use App\Containers\CommunitySection\OrganizationClient\Foundation\OrganizationClient;
use App\Containers\CommunitySection\OrganizationClient\Models\OrganizationClient as OrganizationClientModel;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Item;

class OrganizationClientTransformer extends Transformer
{
    protected array $availableIncludes = [
        OrganizationClient::INCLUDE_ORGANIZATION
    ];

    public function transform(OrganizationClientModel $organizationClient): array
    {
        return [
            OBJECT => $organizationClient->getResourceKey(),
            ID => $organizationClient->getHashedKey(),
            'number' => $organizationClient->getNumber(),
            OrganizationClient::ORGANIZATION_ID => $organizationClient->getHashedKey(
                OrganizationClient::ORGANIZATION_ID
            ),
            OrganizationClient::NAME => $organizationClient->name,
            OrganizationClient::PATRONYMIC => $organizationClient->patronymic,
            OrganizationClient::SURNAME => $organizationClient->surname,
            OrganizationClient::PHONE_NUMBER => $organizationClient->phone_number,
            OrganizationClient::NOTE => $organizationClient->note,
            CREATED_AT => $this->nullOrTimeObject($organizationClient->created_at),
            UPDATED_AT => $this->nullOrTimeObject($organizationClient->updated_at),
            DELETED_AT => $this->nullOrTimeObject($organizationClient->deleted_at)
        ];
    }

    protected function includeOrganization(OrganizationClientModel $organizationClient): Item
    {
        return $this->item($organizationClient->organization, new OrganizationTransformer());
    }
}
