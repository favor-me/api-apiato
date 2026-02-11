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

namespace App\Containers\OrganizationSection\Shift\Data\Factories;

use App\Containers\OrganizationSection\Shift\Models\Shift as ShiftModel;
use App\Containers\OrganizationSection\Shift\Foundation\Shift;
use App\Ship\Database\Eloquent\Collection;
use App\Ship\Parents\Factories\Factory;
use App\Ship\Traits\Factory\HasTrashedState;
use Illuminate\Database\Eloquent\Model;

/**
 * @method Collection|ShiftModel create($attributes = [], ?Model $parent = null)
 * @method Collection|ShiftModel make($attributes = [], ?Model $parent = null)
 */
final class ShiftFactory extends Factory
{
    use HasTrashedState;

    protected $model = ShiftModel::class;

    public function definition(): array
    {
        return [
            'created_by' => null,
            Shift::FINISH_AT => null,
            Shift::ORGANIZATION_ID => null,
            Shift::START_AT => null
        ];
    }
}
