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

use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnitType\Validation\Rules\ExistsOrganizationUnitTypeRule;

return [

    'rules' => [
        OrganizationUnit::NAME => [
            'string'
        ],
        OrganizationUnit::TYPE => [
            new ExistsOrganizationUnitTypeRule()
        ],
        OrganizationUnit::SKU => [
            'string',
            'no_spaces'
        ],
        OrganizationUnit::ORDERING => [
            'integer'
        ],
        OrganizationUnit::COST_PRICE => [
            'nullable',
            'integer',
            'max:' . OrganizationUnit::PRICE_MAX_LENGTH
        ],
        OrganizationUnit::PRICE_UP => [
            'nullable',
            'float'
        ],
        OrganizationUnit::CLIENT_PRICE => [
            'nullable',
            'integer',
            'max:' . OrganizationUnit::PRICE_MAX_LENGTH
        ],
        OrganizationUnit::BALANCE => [
            'nullable',
            'float'
        ]
    ]

];
