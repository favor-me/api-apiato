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

namespace App\Containers\OrderSection\PaymentType\Validation\Rules;

use App\Containers\OrderSection\PaymentType\Facades\Container;
use App\Containers\OrderSection\PaymentType\Manager;
use App\Containers\OrderSection\PaymentType\Type;
use App\Ship\Validation\ValidationRule;
use Closure;

class ExistsPaymentTypeRule extends ValidationRule
{
    public function message(): string
    {
        $types = $this->getManager()
            ->all()
            ->map(fn(Type $type) => $type->getName())
            ->implode(', ');

        return Container::trans('container.validation.exists', [
            'types' => $types
        ]);
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->getManager()->has($value)) {
            $fail($this->message());
        }
    }

    protected function getManager(): Manager
    {
        return Manager::getInstance();
    }
}
