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

namespace App\Containers\OrderSection\Order\Data\Factories;

use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\OrganizationClient\Foundation\OrganizationClient;
use App\Containers\CommunitySection\OrganizationClient\Models\OrganizationClient as OrganizationClientModel;
use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Containers\OrderSection\PaymentType\CashType;
use App\Containers\OrderSection\Status\Foundation\Status;
use App\Containers\OrderSection\Status\Models\Status as StatusModel;
use App\Ship\Database\Eloquent\Collection;
use App\Ship\Parents\Factories\Factory;
use App\Ship\Traits\Factory\HasTrashedState;
use Illuminate\Database\Eloquent\Model;

/**
 * @method Collection|OrderModel create($attributes = [], ?Model $parent = null)
 * @method Collection|OrderModel make($attributes = [], ?Model $parent = null)
 */
final class OrderFactory extends Factory
{
    use HasTrashedState;

    protected $model = OrderModel::class;

    public function definition(): array
    {
        $organization = OrganizationModel::factory()->create();

        $client = OrganizationClientModel::factory()
            ->create([
                OrganizationClient::ORGANIZATION_ID => $organization->id
            ]);

        return [
            Order::CLIENT_ID => $client->id,
            Order::COMMENT => $this->faker->text(50),
            Order::ORGANIZATION_ID => $organization->id,
            Order::PAYMENT_TYPE => CashType::class,
            Order::TOTAL => ZERO,
            Order::PROFIT => ZERO
        ];
    }

    public function completed(): self
    {
        $status = StatusModel::where(Status::SLUG, StatusModel::COMPLETED)->first();

        return $this->state(fn() => [
            Order::STATUS_ID => $status->id
        ]);
    }

    public function canceled(): self
    {
        $status = StatusModel::where(Status::SLUG, StatusModel::CANCELED)->first();

        return $this->state(fn() => [
            Order::STATUS_ID => $status->id
        ]);
    }
}
