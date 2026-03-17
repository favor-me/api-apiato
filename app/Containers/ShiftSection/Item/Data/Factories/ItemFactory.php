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

namespace App\Containers\ShiftSection\Item\Data\Factories;

use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\CommunitySection\Organization\Models\Organization;
use App\Containers\ShiftSection\Item\Foundation\Item;
use App\Containers\ShiftSection\Item\Models\Item as ItemModel;
use App\Containers\ShiftSection\ItemType\IncomeType;
use App\Containers\ShiftSection\Shift\Models\Shift as ShiftModel;
use App\Ship\Database\Eloquent\Collection;
use App\Ship\Parents\Factories\Factory;
use App\Ship\Traits\Factory\HasTrashedState;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @method Collection|ItemModel create($attributes = [], ?Model $parent = null)
 * @method Collection|ItemModel make($attributes = [], ?Model $parent = null)
 */
final class ItemFactory extends Factory
{
    use HasTrashedState;

    protected $model = ItemModel::class;

    public function definition(): array
    {
        /** @var UserModel $user */
        $user = Auth::user();

        if (is_null($user)) {
            $organization = Organization::factory()->create();

            $user = UserModel::factory()
                ->create([
                    User::ORGANIZATION_ID => $organization->id
                ]);
        }

        return [
            CREATED_BY => $user->id,
            Item::DESCRIPTION => $this->faker->text(50),
            Item::ORDER_ID => null,
            Item::SHIFT_ID => ShiftModel::factory(),
            Item::TYPE => IncomeType::class,
            Item::VALUE => 1000,
            Item::SYSTEM_NOTE => []
        ];
    }
}
