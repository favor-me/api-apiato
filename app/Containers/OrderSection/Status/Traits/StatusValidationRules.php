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

namespace App\Containers\OrderSection\Status\Traits;

use App\Containers\OrderSection\Status\Facades\Container;
use App\Containers\OrderSection\Status\Foundation\Status;
use App\Containers\OrderSection\Status\Models\Status as StatusModel;
use App\Ship\Collections\ValidationRules;
use App\Ship\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

trait StatusValidationRules
{
    public function getStatusIdValidationRules(): ValidationRules
    {
        return validation_rules([
            $this->getStatusIdExistsValidationRule(ID)
        ]);
    }

    public function getStatusNameValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . Status::NAME));
    }

    public function getStatusSlugValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . Status::SLUG));
    }

    public function getStatusIsBaseValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . Status::IS_BASE));
    }
    public function getStatusParamsValidationRules(): ValidationRules
    {
        return validation_rules(Container::getConfig('rules.' . 'params'));
    }

    public function getStatusIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return Rule::exists(StatusModel::TABLE, $column);
    }
}
