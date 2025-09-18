<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 */

namespace App\Containers\OrderSection\PaymentType\UI\API\Transformers;

use App\Containers\OrderSection\PaymentType\Type;

class PaymentTypesToListTransformer extends PaymentTypesTransformer
{
    public function transform(Type $type): array
    {
        return [
            'value' => $type->getName(),
            'title' => $type->getTitle()
        ];
    }
}
