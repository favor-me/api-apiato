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

namespace App\Containers\TelegramSection\Bot\Styles;

use App\Containers\TelegramSection\Bot\Contracts\DefaultStyleContract;
use App\Containers\TelegramSection\Bot\Handlers\WebhookHandler;

abstract class Style implements DefaultStyleContract
{
    public function __construct(
        protected WebhookHandler $handler
    ) {
    }
}
