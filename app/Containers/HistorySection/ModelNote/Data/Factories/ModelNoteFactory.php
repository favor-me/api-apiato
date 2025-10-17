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

namespace App\Containers\HistorySection\ModelNote\Data\Factories;

use App\Containers\HistorySection\ModelEvent\Foundation\ModelEvent as BaseModelEvent;
use App\Containers\HistorySection\ModelEvent\Models\ModelEvent;
use App\Containers\HistorySection\ModelNote\Data\Factories\States\SystemMessageModelNoteTypeState;
use App\Containers\HistorySection\ModelNote\Foundation\ModelNote as BaseModelNote;
use App\Containers\HistorySection\ModelNote\Models\ModelNote;
use App\Ship\Parents\Factories\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @method Collection|ModelNote create($attributes = [], ?Model $parent = null)
 */
final class ModelNoteFactory extends Factory
{
    use SystemMessageModelNoteTypeState;

    protected $model = ModelNote::class;

    public function definition(): array
    {
        return [
            BaseModelNote::TYPE => null,
            BaseModelNote::MODEL => null,
            BaseModelNote::MODEL_ID => null,
            BaseModelNote::EVENT_ID => null,
            PARAMS => []
        ];
    }

    public function model(Model $model): self
    {
        $eventModel = ModelEvent::factory()
            ->create([
                BaseModelEvent::MODEL => $model::class,
                BaseModelEvent::MODEL_ID => $model->getAttribute(ID)
            ]);

        return $this->state(fn () => [
            BaseModelNote::EVENT_ID => $eventModel->id,
            BaseModelNote::MODEL => $model::class,
            BaseModelNote::MODEL_ID => $model->getAttribute(ID)
        ]);
    }
}
