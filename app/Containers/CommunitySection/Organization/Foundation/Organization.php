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

namespace App\Containers\CommunitySection\Organization\Foundation;

use App\Ship\Foundation\SectionContainer;

final class Organization extends SectionContainer
{
    public const string COUNTRY = 'country';
    public const string OWNERSHIP_TYPE = 'ownership_type';
    public const int OWNERSHIP_TYPE_MAX_LENGTH = 20;
    public const string EMAIL = 'email';
    public const string BANK_DATA = 'bank_data';
    public const string NAME = 'name';
    public const int NAME_MAX_LENGTH = 100;
    public const string PHONE_NUMBER = 'phone_number';
    public const string USER_OWNER_ID = 'user_owner_id';
    public const string OWNER_NAME = 'owner_name';
    public const string INCLUDE_USER_OWNER = 'user_owner';
    public const string INCLUDE_USERS = 'users';
    public const string INCLUDE_BRANCHES = 'branches';

    protected string $apiBaseUri = 'community/organizations';
}
