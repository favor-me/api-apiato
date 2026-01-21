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

namespace App\Containers\OrderSection\Order\UI\API\Transformers;

use App\Ship\Transformers\TransformerManager;

final class OrderTransformerManager extends TransformerManager
{
    public function getDefault(): OrderTransformer
    {
        return new OrderTransformer();
    }

    public function getAdmin(): AdminOrderTransformer
    {
        return new AdminOrderTransformer();
    }

    public function getToList(): ?OrderToListTransformer
    {
        return new OrderToListTransformer();
    }
}
