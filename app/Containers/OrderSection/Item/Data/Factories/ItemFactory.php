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

namespace App\Containers\OrderSection\Item\Data\Factories;

use App\Containers\CommunitySection\Organization\Models\Organization;
use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\OrderSection\Item\Foundation\Item;
use App\Containers\OrderSection\Item\Models\Item as ItemModel;
use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Ship\Database\Eloquent\Collection;
use App\Ship\Parents\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method Collection|ItemModel create($attributes = [], ?Model $parent = null)
 * @method Collection|ItemModel make($attributes = [], ?Model $parent = null)
 */
final class ItemFactory extends Factory
{
    protected $model = ItemModel::class;

    protected ?int $organizationId = null;
    protected mixed $order = null;

    public function definition(): array
    {
        $clientPrice = app('money')->addCurrency(100);
        $hasOrder = $this->order instanceof OrderModel;

        $order = $hasOrder ? $this->order : OrderModel::factory();

        if (!is_null($this->organizationId) && !$hasOrder) {
            $order = OrderModel::factory(null, [
                Order::ORGANIZATION_ID => $this->organizationId
            ]);
        }

        return [
            Item::AMOUNT => 1,
            Item::CLIENT_PRICE => $clientPrice->val(),
            Item::COST_PRICE => 0,
            Item::NAME => $this->faker->title,
            Item::ORDER_ID => $order,
            Item::SKU => $this->faker->text(50),
            Item::UNIT_ID => null
        ];
    }

    public function organization(mixed $organization): self
    {
        if ($organization instanceof Organization) {
            $organization = $organization->id;
        }

        $this->organizationId = $organization;

        return $this;
    }

    public function order(?OrderModel $order = null): self
    {
        if (!$order instanceof OrderModel) {
            if (!is_null($this->organizationId)) {
                $order = OrderModel::factory()
                    ->create([
                        Order::ORGANIZATION_ID => $this->organizationId
                    ]);
            } else {
                $order = OrderModel::factory()->create();
            }
        }

        $this->order = $order;

        return $this;
    }

    public function unit(?OrganizationUnitModel $unit = null, float $amount = 1): self
    {
        if (is_null($unit)) {
            $data = [];
            if (!is_null($this->organizationId)) {
                $data[OrganizationUnit::ORGANIZATION_ID] = $this->organizationId;
            }

            $unit = OrganizationUnitModel::factory()->create($data);
        }

        return $this->state(fn() => [
            Item::UNIT_ID => $unit->id,
            Item::COST_PRICE => $unit->cost_price->val(),
            Item::CLIENT_PRICE => $unit->client_price->val(),
            Item::SKU => $unit->sku,
            Item::NAME => $unit->name,
            Item::AMOUNT => $amount
        ]);
    }
}
