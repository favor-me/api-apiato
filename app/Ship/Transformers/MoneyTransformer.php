<?php

/**
 * Beauty application system
 *
 * This file is part of the Beauty application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     Proprietary
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved.
 * @link        https://kalistratov.ru
 */

namespace App\Ship\Transformers;

use App\Ship\Parents\Transformers\Transformer;
use App\Ship\SimpleTypes\Type\Money;

class MoneyTransformer extends Transformer
{
    public function transform(Money $exchange): array
    {
        return [
            'currency' => $exchange->currency()->getTransformerData(),
            'exchange' => $exchange->getTransformerData()
        ];
    }
}
