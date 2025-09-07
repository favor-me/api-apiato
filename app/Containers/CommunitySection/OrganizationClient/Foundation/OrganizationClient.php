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

namespace App\Containers\CommunitySection\OrganizationClient\Foundation;

use App\Ship\Foundation\SectionContainer;

final class OrganizationClient extends SectionContainer
{
    public const NAME = 'name';
    public const NOTE = 'note';
    public const ORGANIZATION_ID = 'organization_id';
    public const PATRONYMIC = 'patronymic';
    public const PHONE_NUMBER = 'phone_number';
    public const SURNAME = 'surname';
    public const INCLUDE_ORGANIZATION = 'organization';

    protected string $apiBaseUri = 'community/organization-clients';
}
