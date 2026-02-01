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

namespace App\Containers\TelegramSection\Telegram\Traits;

use App\Containers\TelegramSection\Telegram\Foundation\Telegram;
use App\Ship\Collections\ValidationRules;

trait TelegramUserNameValidationRules
{
    public function getTelegramUserNameValidationRules(): ValidationRules
    {
        return validation_rules([
            'string',
            'nullable',
            'regex:/^[A-Za-z\d_]{' .
            Telegram::USER_NAME_MIN_LENGTH .
            ',' .
            Telegram::USER_NAME_MAX_LENGTH .
            '}$/',
        ]);
    }
}
