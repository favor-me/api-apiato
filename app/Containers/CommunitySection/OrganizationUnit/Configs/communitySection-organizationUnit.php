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

use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnitType\Validation\Rules\ExistsOrganizationUnitTypeRule;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;

return [

    'rules' => [
        OrganizationUnit::NAME => [
            'string'
        ],
        OrganizationUnit::TYPE => [
            new ExistsOrganizationUnitTypeRule()
        ],
        OrganizationUnit::SKU => [
            'nullable',
            'string',
            'no_spaces'
        ],
        OrganizationUnit::ORDERING => [
            'integer'
        ],
        UnitPrice::IS_INFINITY_BALANCE => [
            'boolean'
        ],
        UnitPrice::COST_PRICE => [
            'nullable',
            'numeric',
            'max:' . UnitPrice::PRICE_MAX_LENGTH
        ],
        UnitPrice::PRICE_UP => [
            'nullable',
            'numeric'
        ],
        UnitPrice::CLIENT_PRICE => [
            'nullable',
            'numeric',
            'max:' . UnitPrice::PRICE_MAX_LENGTH
        ],
        UnitPrice::BALANCE => [
            'nullable',
            'numeric'
        ]
    ]

];
