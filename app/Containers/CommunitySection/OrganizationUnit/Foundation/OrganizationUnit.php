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

namespace App\Containers\CommunitySection\OrganizationUnit\Foundation;

use App\Ship\Foundation\SectionContainer;

final class OrganizationUnit extends SectionContainer
{
    public const BALANCE = 'balance';
    public const IS_INFINITY_BALANCE = 'is_infinity_balance';
    public const CLIENT_PRICE = 'client_price';
    public const COST_PRICE = 'cost_price';
    public const NAME = 'name';
    public const ORDERING = 'ordering';
    public const ORGANIZATION_ID = 'organization_id';
    public const PRICE_UP = 'price_up';
    public const SKU = 'sku';
    public const SYSTEM_UNIT_ID = 'system_unit_id';
    public const TYPE = 'type';
    public const INCLUDE_SYSTEM_UNIT = 'systemUnit';
    public const INCLUDE_MODEL_NOTES = 'modelNotes';
    public const PRICE_MAX_LENGTH = 200000 * 100;

    protected string $apiBaseUri = 'community/organization-units';
}
