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

namespace App\Containers\HistorySection\ModelEvent\Data\Factories;

use App\Containers\AppSection\User\Models\User;
use App\Containers\HistorySection\ModelEvent\Models\ModelEvent;
use App\Ship\Parents\Factories\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Containers\HistorySection\ModelEvent\Foundation\ModelEvent as BaseModelEvent;

/**
 * @method ModelEvent|Collection create($attributes = [], ?Model $parent = null)
 */
final class ModelEventFactory extends Factory
{
    private const DEFAULT_TYPE = 'created_user';

    protected $model = ModelEvent::class;

    public function definition(): array
    {
        $user = User::factory()->create();

        return [
            BaseModelEvent::TYPE => self::DEFAULT_TYPE,
            BaseModelEvent::MODEL => $user::class,
            BaseModelEvent::MODEL_ID => $user->id,
            BaseModelEvent::DATA => [],
            BaseModelEvent::DATA_CHANGES => $user->toArray()
        ];
    }

    public function model(Model $model): self
    {
        return $this->state(fn () => [
            BaseModelEvent::MODEL => $model::class,
            BaseModelEvent::MODEL_ID => $model->getAttribute(ID)
        ]);
    }
}
