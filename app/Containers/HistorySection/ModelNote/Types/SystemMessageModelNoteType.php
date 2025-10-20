<?php

/**
 * ERP system
 *
 * This file is part of the ERM system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    Proprietary
 * @copyright  Copyright (C) zemlechist.ru, All rights reserved.
 * @link       https://zemlechist.ru
 */

namespace App\Containers\HistorySection\ModelNote\Types;

use App\Containers\HistorySection\ModelNote\Facades\Container;
use App\Containers\HistorySection\ModelNote\Models\ModelNote as ModelNoteModel;
use JBZoo\Data\JSON;

class SystemMessageModelNoteType extends ModelNoteType
{
    public const PARAM_KEY_MESSAGE = 'message';
    public const PARAM_KEY_MESSAGE_ARGS = 'message_args';

    public function factoryParamsDefinition(array $params = []): array
    {
        return $this->prepareModelNoteParams(array_merge([
            self::PARAM_KEY_MESSAGE => Container::trans('container.factory_default_message'),
            self::PARAM_KEY_MESSAGE_ARGS => []
        ], $params));
    }

    public function getAllowedParamKeys(): array
    {
        return [
            self::PARAM_KEY_MESSAGE,
            self::PARAM_KEY_MESSAGE_ARGS
        ];
    }

    public function getTransformerParams(JSON $params): array
    {
        $messageTransKey = $params->get(self::PARAM_KEY_MESSAGE);
        $messageTransKeyArgs = $params->get(self::PARAM_KEY_MESSAGE_ARGS);

        return [
            self::PARAM_KEY_MESSAGE => __($messageTransKey, $messageTransKeyArgs)
        ];
    }
}
