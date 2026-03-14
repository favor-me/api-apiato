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
    public const string PRIORITY_FROM = 'priority_from';
    public const string PRIORITY_BALANCE = 'priority_balance';
    public const string PRIORITY_COST_PRICE = 'priority_cost_price';
    public const string PRIORITY_CLIENT_PRICE = 'priority_client_price';
    public const string PRIORITY_IS_INFINITY_BALANCE = 'priority_is_infinity_balance';

    protected string $apiBaseUri = 'community/organization-units';
}
