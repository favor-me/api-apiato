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

namespace App\Containers\OrganizationSection\Shift\Foundation;

use App\Ship\Foundation\SectionContainer;

final class Shift extends SectionContainer
{
    public const string FINISH_AT = 'finish_at';
    public const string ORGANIZATION = 'organization';
    public const string ORGANIZATION_ID = 'organization_id';
    public const string ORGANIZATION_BRANCH = 'organization_branch';
    public const string ORGANIZATION_BRANCH_ID = 'organization_branch_id';
    public const string CREATOR = 'creator';
    public const string EXCLUDE_ORGANIZATION_BRANCH = 'exclude_organization_branch';
    public const string START_AT = 'start_at';

    protected string $apiBaseUri = 'organization/shifts';
}
