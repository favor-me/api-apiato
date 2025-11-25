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
    /**
     * @deprecated use UnitPrice::IS_INFINITY_BALANCE
     */
    public const string BALANCE = 'balance';

    /**
     * @deprecated use UnitPrice::IS_INFINITY_BALANCE
     */
    public const string IS_INFINITY_BALANCE = 'is_infinity_balance';

    /**
     * @deprecated use UnitPrice::CLIENT_PRICE
     */
    public const string CLIENT_PRICE = 'client_price';

    /**
     * @deprecated use UnitPrice::COST_PRICE
     */
    public const string COST_PRICE = 'cost_price';
    public const string NAME = 'name';
    public const string ORDERING = 'ordering';
    public const string ORGANIZATION_ID = 'organization_id';

    /**
     * @deprecated use UnitPrice::PRICE_UP
     */
    public const string PRICE_UP = 'price_up';
    public const string SKU = 'sku';
    public const string SYSTEM_UNIT_ID = 'system_unit_id';
    public const string TYPE = 'type';
    public const string SYSTEM_UNIT = 'systemUnit';
    public const string MODEL_NOTES = 'modelNotes';
    public const string CONTACT_PRICE_LIST = 'contractPriceList';

    /**
     * @deprecated use UnitPrice::PRICE_MAX_LENGTH
     */
    public const int PRICE_MAX_LENGTH = 200000 * 100;

    protected string $apiBaseUri = 'community/organization-units';
}
