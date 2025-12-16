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

use App\Containers\CommunitySection\Counterparty\Foundation\Counterparty;
use App\Containers\CommunitySection\Counterparty\Validation\Rules\ExistsCounterpartyCountryRule;
use App\Containers\OrganizationSection\OwnershipType\Validation\Rules\ExistsOwnershipTypeRule;
use App\Ship\Support\Email;
use App\Ship\Support\PhoneNumber;

return [

    'rules' => [
        Counterparty::NAME => [
            'string',
            'min:1',
            'max:' . SCHEMA_DEFAULT_STRING_LENGTH
        ],
        Counterparty::LEGAL_ADDRESS => [
            'string',
            'min:1',
            'max:' . SCHEMA_DEFAULT_STRING_LENGTH
        ],
        Counterparty::PHONE_NUMBER => [
            PhoneNumber::getValidationRule()
        ],
        Counterparty::EMAIL => [
            'nullable',
            'email',
            'max:' . Email::MAX_LENGTH,
        ],
        Counterparty::COUNTRY => [
            new ExistsCounterpartyCountryRule()
        ],
        Counterparty::OWNERSHIP_TYPE => [
            new ExistsOwnershipTypeRule()
        ]
    ]

];
