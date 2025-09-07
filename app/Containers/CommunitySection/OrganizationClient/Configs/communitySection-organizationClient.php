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

use App\Containers\CommunitySection\OrganizationClient\Foundation\OrganizationClient;
use App\Ship\Support\PhoneNumber;

return [

    'rules' => [

        OrganizationClient::NAME => [
            'string',
            'min:1',
            'max:' . SCHEMA_DEFAULT_STRING_LENGTH
        ],
        OrganizationClient::PATRONYMIC => [
            'nullable',
            'string',
            'max:' . SCHEMA_DEFAULT_STRING_LENGTH
        ],
        OrganizationClient::SURNAME => [
            'nullable',
            'string',
            'max:' . SCHEMA_DEFAULT_STRING_LENGTH
        ],
        OrganizationClient::PHONE_NUMBER => [
            PhoneNumber::getValidationRule()
        ],
        OrganizationClient::NOTE => [
            'nullable',
            'string',
            'max:' . SCHEMA_DEFAULT_STRING_LENGTH
        ]
    ]

];
