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

use App\Containers\CommunitySection\OrganizationBranch\Foundation\OrganizationBranch;
use App\Ship\Support\PhoneNumber;

return [

    'rules' => [
        OrganizationBranch::NAME => [
            'string',
        ],
        OrganizationBranch::PHONE_NUMBER => [
            PhoneNumber::getValidationRule()
        ],
        OrganizationBranch::LOCATION => [
            'string'
        ],
        OrganizationBranch::LATITUDE => [
            'nullable',
            'numeric',
            'between:-90,90'
        ],
        OrganizationBranch::LONGITUDE => [
            'nullable',
            'numeric',
            'between:-180,180'
        ]
    ]

];
