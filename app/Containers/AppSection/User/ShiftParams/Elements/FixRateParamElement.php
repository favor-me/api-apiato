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

namespace App\Containers\AppSection\User\ShiftParams\Elements;

use App\Containers\AppSection\User\Facades\Container;
use App\Containers\AppSection\User\Foundation\User;
use App\Ship\Collections\ValidationRules;
use App\Ship\Params\IntParam;

class FixRateParamElement extends IntParam
{
    protected string $name = User::SHIFT_PARAMS_FIX_RATE;

    public static function getValidationRules(): ValidationRules
    {
        return parent::getValidationRules()
            ->add('numeric');
    }

    protected function getTitle(): string
    {
        return Container::trans('container.shift_params.' . $this->name . '.title');
    }

    protected function getHint(): string
    {
        return Container::trans('container.shift_params.' . $this->name . '.hint');
    }
}
