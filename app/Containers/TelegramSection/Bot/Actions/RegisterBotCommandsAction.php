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

namespace App\Containers\TelegramSection\Bot\Actions;

use App\Containers\TelegramSection\Bot\Tasks\RegisterBotCommandsTask;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action;
use DefStudio\Telegraph\Client\TelegraphResponse;

class RegisterBotCommandsAction extends Action
{
    /**
     * @return TelegraphResponse
     * @throws NotFoundException
     */
    public function run(): TelegraphResponse
    {
        return app(RegisterBotCommandsTask::class)->run();
    }
}
