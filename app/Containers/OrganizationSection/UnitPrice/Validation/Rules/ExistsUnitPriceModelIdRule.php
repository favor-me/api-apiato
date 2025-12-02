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

namespace App\Containers\OrganizationSection\UnitPrice\Validation\Rules;

use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\OrganizationSection\UnitPrice\Map\Manager;
use App\Containers\OrganizationSection\UnitPrice\Map\Type;
use App\Ship\Validation\ValidationRule;
use Closure;

class ExistsUnitPriceModelIdRule extends ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->hasModel()) {
            $modelType = $this->getModelType();
            if (!$modelType->existsModelId($value)) {
                $fail($modelType->noExistsModelIdValidationMessage());
            }
        }
    }

    protected function hasModel(): bool
    {
        if (!$this->getModel()) {
            return false;
        }

        return $this->getManager()
            ->has(
                $this->getModel()
            );
    }

    protected function getModelType(): ?Type
    {
        return $this->getManager()
            ->get(
                $this->getModel()
            );
    }

    protected function getModel(): mixed
    {
        return $this->data->get(UnitPrice::MODEL);
    }

    protected function getManager(): Manager
    {
        return Manager::getInstance();
    }
}
