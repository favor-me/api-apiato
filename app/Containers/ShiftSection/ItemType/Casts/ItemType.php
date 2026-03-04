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

namespace App\Containers\ShiftSection\ItemType\Casts;

use App\Containers\ShiftSection\ItemType\Manager;
use App\Containers\ShiftSection\ItemType\Type;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Database\Eloquent\SerializesCastableAttributes;
use Illuminate\Database\Eloquent\Model;

final class ItemType implements CastsAttributes, SerializesCastableAttributes
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        if (is_null($value)) {
            return null;
        }

        return Manager::getInstance()->get($value);
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value instanceof Type) {
            return $value->getName();
        }

        return $value;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function serialize(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($value instanceof Type) {
            return $value->getName();
        }

        return $value;
    }
}
