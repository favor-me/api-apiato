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

use App\Containers\TelegramSection\Bot\Facades\Container;
use DefStudio\Telegraph\Keyboard\ReplyKeyboard;
use DefStudio\Telegraph\Telegraph;

class ForgotPasswordAction extends MessageAction
{
    public function __invoke(): void
    {
        $this->handler
            ->getStorage()
            ->set($this->handler::STORE_START_REMEMBER_PWD, true);

        parent::__invoke();
    }

    public function getMessage(): string
    {
        return $this->style->getRememberPwdMessage();
    }

    protected function createChatMessage(): Telegraph
    {
        return parent::createChatMessage()
            ->replyKeyboard(
                ReplyKeyboard::make()
                    ->button(
                        Container::trans('default.send_contact')
                    )
                    ->requestContact()
            );
    }
}
