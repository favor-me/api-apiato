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

namespace App\Containers\ShiftSection\Item\Dto;

class SystemNoteDto
{
    public const string MESSAGE = 'message';
    public const string MESSAGE_ARGS = 'message_args';

    public function __construct(
        protected string $message,
        protected array $messageArgs = []
    ) {
    }

    public function toArray(): array
    {
        return [
            self::MESSAGE => $this->message,
            self::MESSAGE_ARGS => $this->messageArgs
        ];
    }
}
