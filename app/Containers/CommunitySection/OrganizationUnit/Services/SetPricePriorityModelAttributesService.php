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

namespace App\Containers\CommunitySection\OrganizationUnit\Services;

use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\OrganizationSection\UnitPrice\Map\ContractType;
use App\Containers\OrganizationSection\UnitPrice\Map\Manager;
use Illuminate\Support\Collection;

class SetPricePriorityModelAttributesService
{
    protected array $priorityAttributes = [
        OrganizationUnit::PRIORITY_FROM => null,
        OrganizationUnit::PRIORITY_BALANCE => null,
        OrganizationUnit::PRIORITY_PRICE_UP => null,
        OrganizationUnit::PRIORITY_COST_PRICE => null,
        OrganizationUnit::PRIORITY_CLIENT_PRICE => null,
        OrganizationUnit::PRIORITY_IS_INFINITY_BALANCE => null
    ];

    protected Collection $attributes;

    public function __construct(array $attributes)
    {
        $this->attributes = collect($attributes);
        $this->setDefaultPriorityAttributes();
    }

    protected function setDefaultPriorityAttributes(): void
    {
        $this->priorityAttributes = [
            OrganizationUnit::PRIORITY_FROM => null,
            OrganizationUnit::PRIORITY_BALANCE => $this->attributes->get(UnitPrice::BALANCE),
            OrganizationUnit::PRIORITY_PRICE_UP => $this->attributes->get(UnitPrice::PRICE_UP),
            OrganizationUnit::PRIORITY_COST_PRICE => $this->attributes->get(UnitPrice::COST_PRICE),
            OrganizationUnit::PRIORITY_CLIENT_PRICE => $this->attributes->get(UnitPrice::CLIENT_PRICE),
            OrganizationUnit::PRIORITY_IS_INFINITY_BALANCE => $this->attributes->get(UnitPrice::IS_INFINITY_BALANCE)
        ];
    }

    public function run(): array
    {
        $manager = Manager::getInstance();

        $manager->get(ContractType::class)
            ->setPriorityModelAttributes(
                $this->attributes,
                $this->priorityAttributes
            );

        return $this->attributes->toArray() + $this->priorityAttributes;
    }
}
