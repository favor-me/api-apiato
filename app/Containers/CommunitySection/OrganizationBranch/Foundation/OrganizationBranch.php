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

namespace App\Containers\CommunitySection\OrganizationBranch\Foundation;

use App\Ship\Foundation\SectionContainer;

final class OrganizationBranch extends SectionContainer
{
    public const LATITUDE = 'latitude';
    public const LOCATION = 'location';
    public const LONGITUDE = 'longitude';
    public const NAME = 'name';
    public const ORGANIZATION_ID = 'organization_id';
    public const PHONE_NUMBER = 'phone_number';
    public const RESPONSIBLE_BY = 'responsible_by';
    public const INCLUDE_RESPONSIBLE = 'responsible';
    public const INCLUDE_ORGANIZATION = 'organization';

    protected string $apiBaseUri = 'community/organization-branches';
}
