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

namespace App\Containers\HistorySection\ModelEvent\UI\API\Transformers;

use App\Containers\HistorySection\ModelEvent\Foundation\ModelEventType;
use App\Ship\Parents\Transformers\Transformer;

class ModelEventTypeTransformer extends Transformer
{
    public const NAME = 'name';
    public const TYPE = 'type';
    public const GROUP = 'group';

    public function transform(ModelEventType $eventType): array
    {
        return [
            self::NAME => $eventType->getName(),
            self::TYPE => $eventType::getType(),
            self::GROUP => $eventType->getGroup()
        ];
    }
}
