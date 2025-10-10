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

namespace App\Containers\OrderSection\Status\Data\Factories;

use App\Containers\OrderSection\Status\Models\Status as StatusModel;
use App\Containers\OrderSection\Status\Foundation\Status;
use App\Ship\Database\Eloquent\Collection;
use App\Ship\Parents\Factories\Factory;
use App\Ship\Traits\Factory\HasTrashedState;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @method Collection|StatusModel create($attributes = [], ?Model $parent = null)
 * @method Collection|StatusModel make($attributes = [], ?Model $parent = null)
 */
final class StatusFactory extends Factory
{
    use HasTrashedState;

    protected $model = StatusModel::class;

    public function definition(): array
    {
        $name = $this->faker->title;

        return [
            Status::IS_BASE => true,
            Status::NAME => $name,
            PARAMS => null,
            Status::SLUG => Str::slug($name)
        ];
    }
}
