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

namespace App\Containers\OrderSection\Item\Dto;

use App\Ship\Dto\Dto;

class CreateItemDto extends Dto
{
    public ?float $amount = 1;
    public ?int $client_price;
    public ?int $cost_price;
    public ?string $name;
    public ?int $order_id;
    public ?string $sku;
    public ?int $unit_id;
}
