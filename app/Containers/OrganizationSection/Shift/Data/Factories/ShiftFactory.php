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

use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\CommunitySection\Organization\Models\Organization;
use App\Containers\OrganizationSection\Shift\Foundation\Shift;
use App\Containers\OrganizationSection\Shift\Models\Shift as ShiftModel;
use App\Ship\Database\Eloquent\Collection;
use App\Ship\Parents\Factories\Factory;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * @method Collection|ShiftModel create($attributes = [], ?Model $parent = null)
 * @method Collection|ShiftModel make($attributes = [], ?Model $parent = null)
 */
final class ShiftFactory extends Factory
{
    protected $model = ShiftModel::class;

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
            Shift::FINISH_AT => Carbon::now()->addHours(8),
            Shift::ORGANIZATION_ID => $user->organization_id,
            Shift::ORGANIZATION_BRANCH_ID => $user->organization_branch_id,
            Shift::MONEY => ZERO,
            Shift::START_AT => Carbon::now()
        ];
    }
}
