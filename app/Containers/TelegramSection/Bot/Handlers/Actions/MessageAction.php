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

namespace App\Containers\TelegramSection\Bot\Handlers\Actions;

use DefStudio\Telegraph\Client\TelegraphResponse;
use DefStudio\Telegraph\Models\TelegraphChat;
use DefStudio\Telegraph\Telegraph;

abstract class MessageAction extends Action
{
    public function __invoke(): void
    {
        parent::__invoke();

        $response = $this->send();
    }

    abstract public function getMessage(): string;

    protected function send(): ?TelegraphResponse
    {
        return $this
            ->createChatMessage()
            ->send();
    }

    protected function createChatMessage(): Telegraph
    {
        return $this->getChat()
            ->message(
                $this->getMessage()
            );
    }

    protected function getChat(): TelegraphChat
    {
        return $this->handler->getChat();
    }
}
