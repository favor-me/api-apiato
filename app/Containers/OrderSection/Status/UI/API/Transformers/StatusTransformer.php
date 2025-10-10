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

namespace App\Containers\OrderSection\Status\UI\API\Transformers;

use App\Containers\OrderSection\Status\Foundation\Status;
use App\Containers\OrderSection\Status\Models\Status as StatusModel;
use App\Ship\Parents\Transformers\Transformer;

class StatusTransformer extends Transformer
{
    public function transform(StatusModel $status): array
    {
        return [
            OBJECT => $status->getResourceKey(),
            ID => $status->getHashedKey(),
            Status::NAME => $status->name,
            Status::SLUG => $status->slug,
            Status::IS_BASE => $status->is_base,
            PARAMS => $status->params
        ];
    }
}
