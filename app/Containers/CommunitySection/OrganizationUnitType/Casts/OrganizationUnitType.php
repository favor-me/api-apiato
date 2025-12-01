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

namespace App\Containers\CommunitySection\OrganizationUnitType\Casts;

use App\Containers\CommunitySection\OrganizationUnitType\Manager;
use App\Containers\CommunitySection\OrganizationUnitType\Type;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Database\Eloquent\SerializesCastableAttributes;

class OrganizationUnitType implements CastsAttributes, SerializesCastableAttributes
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function get($model, string $key, $value, array $attributes): mixed
    {
        if (is_null($value)) {
            return null;
        }

        $manager = Manager::getInstance();
        if ($manager->has($value)) {
            return $manager->get($value);
        }

        return $value;
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
