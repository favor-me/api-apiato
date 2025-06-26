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

namespace App\Ship\Channels\Telegram;

use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\TelegramSection\Bot\Data\Repositories\BotRepository;
use App\Containers\TelegramSection\Bot\Foundation\Bot;
use App\Containers\TelegramSection\Bot\Models\TelegraphBot;
use App\Ship\Criterias\ThisEqualThatCriteria;
use NotificationChannels\Telegram\TelegramMessage as BaseTelegramMessage;
use Prettus\Repository\Exceptions\RepositoryException;

class TelegramMessage extends BaseTelegramMessage
{
    public static function create(string $content = ''): self
    {
        return new static($content);
    }

    /**
     * @param mixed $user
     * @return $this
     * @throws RepositoryException
     */
    public function findUserBotAndSetToken(mixed $user): self
    {
        $bot = null;
        if (is_int($user) || is_string($user)) {
            $bot = $this->findUserBot($user);
        } elseif ($user instanceof UserModel) {
            $bot = $this->token($user->id);
        }

        if (!is_null($bot)) {
            $this->token($bot->token);
        }

        return $this;
    }

    /**
     * @param int|string $id
     * @return TelegraphBot|null
     * @throws RepositoryException
     */
    protected function findUserBot(int|string $id): ?TelegraphBot
    {
        return app(BotRepository::class)
            ->pushCriteria(new ThisEqualThatCriteria(Bot::CREATED_FOR, $id))
            ->first();
    }
}
