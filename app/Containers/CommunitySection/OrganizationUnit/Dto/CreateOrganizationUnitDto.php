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

namespace App\Containers\CommunitySection\OrganizationUnit\Dto;

use App\Ship\Dto\Dto;

class CreateOrganizationUnitDto extends Dto
{
    public ?float $balance;
    public bool $is_infinity_balance = false;
    public ?string $client_price;
    public ?string $cost_price;
    public ?string $name;
    public int $ordering = ZERO;
    public ?int $organization_id;
    public ?string $params;
    public ?string $price_up;
    public ?string $sku;
    public ?int $system_unit_id;
    public ?string $type;
}
