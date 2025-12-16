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

namespace App\Containers\CommunitySection\Counterparty\Foundation;

use App\Ship\Foundation\SectionContainer;

final class Counterparty extends SectionContainer
{
    public const string LEGAL_ADDRESS = 'legal_address';
    public const string MAILING_ADDRESS = 'mailing_address';
    public const string BANK_DATA = 'bank_data';
    public const string OWNERSHIP_TYPE = 'ownership_type';
    public const string BANK_DATA_SCHEMA = 'bank_data_schema';
    public const string COUNTRY = 'country';
    public const int COUNTRY_MAX_LENGTH = 2;
    public const string EMAIL = 'email';
    public const string NAME = 'name';
    public const string ORGANIZATION_ID = 'organization_id';
    public const string PHONE_NUMBER = 'phone_number';

    protected string $apiBaseUri = 'community/counterparties';
}
