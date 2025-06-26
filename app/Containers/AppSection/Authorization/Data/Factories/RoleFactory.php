<?php

/**
 * Beauty application system
 *
 * This file is part of the Beauty application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     Proprietary
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved.
 * @link        https://kalistratov.ru
 */

namespace App\Containers\AppSection\Authorization\Data\Factories;

use App\Ship\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Containers\AppSection\Authorization\Models\Role;
use Illuminate\Database\Eloquent\Model;

/**
 * @method Model|Collection|Role create($attributes = [], ?Model $parent = null)
 */
class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->slug
        ];
    }
}
