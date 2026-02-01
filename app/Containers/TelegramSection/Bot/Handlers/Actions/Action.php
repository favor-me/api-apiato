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

use App\Containers\TelegramSection\Bot\Handlers\WebhookHandler;
use App\Containers\TelegramSection\Bot\Styles\DefaultStyle;
use App\Containers\TelegramSection\Bot\Styles\Style;

abstract class Action
{
    protected Style $style;

    public function __construct(
        protected WebhookHandler $handler
    ) {
        $this->init();
    }

    public function __invoke(): void
    {
    }

    protected function init(): void
    {
        $this->setStyle();
    }

    protected function setStyle(): void
    {
        $this->style = $this->styleAccessor();
    }

    protected function styleAccessor(): Style
    {
        return new DefaultStyle($this->handler);
    }
}
