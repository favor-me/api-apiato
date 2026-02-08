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

namespace App\Containers\TelegramSection\Bot\Tasks;

use App\Containers\TelegramSection\Bot\Facades\Container;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use DefStudio\Telegraph\Client\TelegraphResponse;
use DefStudio\Telegraph\Models\TelegraphBot;

class RegisterBotCommandsTask extends Task
{
    /**
     * @param TelegraphBot|null $bot
     * @return TelegraphResponse
     * @throws NotFoundException
     */
    public function run(?TelegraphBot $bot = null): TelegraphResponse
    {
        if (is_null($bot)) {
            $bot = TelegraphBot::first();
        }

        if (is_null($bot)) {
            throw new NotFoundException();
        }

        return $bot
            ->registerCommands(
                $this->commands()
            )
            ->send();
    }

    protected function commands(): array
    {
        return [
            'start' => Container::trans('default.commands.start'),
            'forgot_password' => Container::trans('default.commands.forgot_password')
        ];
    }
}
