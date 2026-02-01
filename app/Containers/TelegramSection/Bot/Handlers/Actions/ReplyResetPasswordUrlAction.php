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

use DefStudio\Telegraph\Telegraph;

class ReplyResetPasswordUrlAction extends MessageAction
{
    protected ?string $url = null;

    public function __invoke(): void
    {
        $this->handler
            ->getStorage()
            ->delete();

        parent::__invoke();
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    protected function createChatMessage(): Telegraph
    {
        return $this
            ->getChat()
            ->html(
                $this->getMessage()
            );
    }

    public function getMessage(): string
    {
        return $this->style->getResetPasswordUrlMessage($this->url);
    }
}
