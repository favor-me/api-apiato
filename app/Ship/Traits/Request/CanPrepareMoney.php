<?php

/**
 * ERP system
 *
 * This file is part of the ERM system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license https://kalistratov.ru/licenses/erp Proprietary license
 * @copyright Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link https://kalistratov.ru
 * @author Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Ship\Traits\Request;

trait CanPrepareMoney
{
    protected function convertMoneyToSave($value): float
    {
        return app('money')
            ->addCurrency($value)
            ->val();
    }

    protected function prepareMoney(string $moneyFieldName): self
    {
        if ($this->has($moneyFieldName)) {
            $this->merge([
                $moneyFieldName => $this->convertMoneyToSave($this->get($moneyFieldName))
            ]);
        }

        return $this;
    }
}
