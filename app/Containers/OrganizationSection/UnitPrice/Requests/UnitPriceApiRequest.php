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

namespace App\Containers\OrganizationSection\UnitPrice\Requests;

use App\Containers\OrganizationSection\UnitPrice\Traits\UnitPriceValidationRules;
use App\Containers\OrganizationSection\UnitPrice\UI\API\Transformers\UnitPriceTransformerManager;
use App\Ship\Contracts\GettableTransformer;
use App\Ship\Parents\Transformers\Transformer;
use App\Ship\Requests\ApiRequest;

abstract class UnitPriceApiRequest extends ApiRequest implements GettableTransformer
{
    use UnitPriceValidationRules;

    public function getTransformer(): Transformer
    {
        return (new UnitPriceTransformerManager())->getDefaultOrAdmin();
    }
}
