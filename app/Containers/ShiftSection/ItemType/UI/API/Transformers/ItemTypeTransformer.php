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

namespace App\Containers\ShiftSection\ItemType\UI\API\Transformers;

use App\Containers\ShiftSection\ItemType\Type;
use App\Ship\Parents\Transformers\Transformer;

class ItemTypeTransformer extends Transformer
{
    public function transform(Type $type): array
    {
        return $type->toArray();
    }
}
