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

namespace App\Containers\ShiftSection\Shift\UI\API\Requests;

use App\Containers\ShiftSection\Shift\Foundation\Shift;
use App\Containers\ShiftSection\Shift\Traits\ShiftValidationRules;
use Illuminate\Validation\Rules\Exists;

class PaidShiftsRequest extends ConfirmShiftsRequest
{
    use ShiftValidationRules {
        getShiftIdExistsValidationRule as parentGetShiftIdExistsValidationRule;
    }

    public function getShiftIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return $this->parentGetShiftIdExistsValidationRule($column)
            ->where(Shift::ORGANIZATION_ID, $this->organization_id)
            ->whereNull(Shift::PAYMENT_AT);
    }
}
