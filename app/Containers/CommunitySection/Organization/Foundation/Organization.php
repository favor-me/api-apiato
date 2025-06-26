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
    public const EMAIL = 'email';
    public const INN = 'inn';
    public const INN_MAX_LENGTH = 50;
    public const NAME = 'name';
    public const NAME_MAX_LENGTH = 100;
    public const PHONE_NUMBER = 'phone_number';
    public const USER_OWNER_ID = 'user_owner_id';
    public const INCLUDE_USER_OWNER = 'user_owner';

    protected string $apiBaseUri = 'community/organizations';
}
