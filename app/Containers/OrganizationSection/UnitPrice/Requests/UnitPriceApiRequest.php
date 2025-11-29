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

use App\Containers\CommunitySection\OrganizationUnit\Traits\OrganizationUnitValidationRules;
use App\Containers\CommunitySection\OrganizationUnit\UI\API\Transformers\OrganizationUnitTransformerManager;
use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\OrganizationSection\UnitPrice\Map\Manager;
use App\Containers\OrganizationSection\UnitPrice\Map\Type;
use App\Containers\OrganizationSection\UnitPrice\Traits\UnitPriceValidationRules;
use App\Ship\Contracts\GettableTransformer;
use App\Ship\Parents\Transformers\Transformer;
use App\Ship\Requests\ApiRequest;

/**
 * @property-read string $model
 */
abstract class UnitPriceApiRequest extends ApiRequest implements GettableTransformer
{
    use UnitPriceValidationRules;
    use OrganizationUnitValidationRules;

    protected array $urlParameters = [
        UnitPrice::MODEL
    ];

    public function getTransformer(): Transformer
    {
        return (new OrganizationUnitTransformerManager())
            ->getDefaultOrAdmin();
    }

    public function getModelType(): Type
    {
        return Manager::getInstance()
            ->get($this->model);
    }
}
