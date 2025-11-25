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

namespace App\Containers\OrganizationSection\UnitPrice\Dto;

use App\Ship\Dto\Dto;

class CreateUnitPriceDto extends Dto
{
    public ?string $client_price;
    public ?string $cost_price;
    public ?string $model;
    public ?string $model_id;
    public ?string $price_up;
    public ?string $unit_id;
}
