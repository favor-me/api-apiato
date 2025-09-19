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

namespace App\Containers\OrderSection\Order\Dto;

use App\Ship\Dto\Dto;

class CreateOrderDto extends Dto
{
    public ?int $client_id;
    public ?string $comment;
    public ?int $organization_id;
    public ?string $payment_type;
    public ?string $total;
    public ?string $profit;
    public array $items = [];

    public function hasItems(): bool
    {
        return count($this->items) > ZERO;
    }
}
