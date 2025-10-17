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

namespace App\Containers\HistorySection\ModelNote\Data\Factories\States;

use App\Containers\HistorySection\ModelNote\Foundation\ModelNote as BaseModelNote;
use App\Containers\HistorySection\ModelNote\Types\ModelNoteTypeManager;
use App\Containers\HistorySection\ModelNote\Types\SystemMessageModelNoteType;

trait SystemMessageModelNoteTypeState
{
    public function typeSystemMessage(?string $message = null): self
    {
        /** @var SystemMessageModelNoteType $type */
        $type = ModelNoteTypeManager::getInstance()->get(SystemMessageModelNoteType::class);

        return $this->state(function () use ($type, $message) {
            $arguments = [];

            if (!is_null($message)) {
                $arguments[$type::PARAM_KEY_MESSAGE] = $message;
            }

            return [
                BaseModelNote::TYPE => $type::getKey(),
                PARAMS => $type->factoryParamsDefinition($arguments)
            ];
        });
    }
}
