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

namespace App\Containers\OrganizationSection\OwnershipType\Casts;

use App\Containers\OrganizationSection\OwnershipType\Manager;
use App\Containers\OrganizationSection\OwnershipType\Type;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Database\Eloquent\SerializesCastableAttributes;

class OwnershipType implements CastsAttributes, SerializesCastableAttributes
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function get($model, string $key, $value, array $attributes): ?Type
    {
        if (is_null($value)) {
            return null;
        }

        return Manager::getInstance()->get($value);
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function set($model, string $key, $value, array $attributes): mixed
    {
        if ($value instanceof Type) {
            return $value->getName();
        }

        return $value;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function serialize($model, string $key, $value, array $attributes): mixed
    {
        if ($value instanceof Type) {
            return $value->getName();
        }

        return $value;
    }
}
