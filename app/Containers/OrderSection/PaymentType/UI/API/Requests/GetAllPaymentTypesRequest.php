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

namespace App\Containers\OrderSection\PaymentType\UI\API\Requests;

use App\Containers\OrderSection\PaymentType\UI\API\Transformers\PaymentTypesToListTransformer;
use App\Containers\OrderSection\PaymentType\UI\API\Transformers\PaymentTypesTransformer;
use App\Ship\Contracts\GettableTransformer;
use App\Ship\Parents\Transformers\Transformer;
use App\Ship\Requests\ApiRequest;

class GetAllPaymentTypesRequest extends ApiRequest implements GettableTransformer
{
    public function getTransformer(): Transformer
    {
        return !$this->isToList() ? new PaymentTypesTransformer() : new PaymentTypesToListTransformer();
    }
}
