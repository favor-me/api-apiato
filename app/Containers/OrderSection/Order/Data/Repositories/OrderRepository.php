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

namespace App\Containers\OrderSection\Order\Data\Repositories;

use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Ship\Parents\Repositories\Repository;

/**
 * @method OrderModel getModel()
 */
final class OrderRepository extends Repository
{
    protected $fieldSearchable = [
        ID => '=',
        CREATED_BY => 'in',
        Order::PAYMENT_TYPE => '=',
        Order::CLIENT_ID => '=',
        Order::STATUS_ID => '=',
        Order::CLIENT => '='
    ];

    public function model(): string
    {
        return OrderModel::class;
    }
}
