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

namespace App\Containers\TelegramSection\Bot\Handlers\Actions;

use App\Containers\TelegramSection\Bot\Facades\Container;
use DefStudio\Telegraph\Keyboard\ReplyKeyboard;
use DefStudio\Telegraph\Telegraph;

class ReplyInvalidClientPhoneNumberAction extends MessageAction
{
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

    public function getMessage(): string
    {
        return $this->style->getInvalidClientPhoneNumberMessage();
    }
}
