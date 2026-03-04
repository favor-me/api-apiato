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

namespace App\Containers\ShiftSection\ItemType\Validation\Rules;

use App\Containers\ShiftSection\ItemType\Facades\Container;
use App\Containers\ShiftSection\ItemType\Manager;
use App\Ship\Validation\ValidationRule;
use Closure;

class ExistsItemTypeRule extends ValidationRule
{
    public function message(): string
    {
        $types = $this->getManager()
            ->all()
            ->implode(', ');

        return Container::trans('container.validation.exists', [
            'types' => $types
        ]);
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
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
