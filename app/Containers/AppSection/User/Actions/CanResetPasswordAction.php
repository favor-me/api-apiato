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

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Tasks\CanResetPasswordTask;
use App\Containers\TelegramSection\Bot\Handlers\Actions\Action;

class CanResetPasswordAction extends Action
{
    public function run(string $token, string $columnValue): bool
    {
        return app(CanResetPasswordTask::class)->run($token, $columnValue);
    }
}
