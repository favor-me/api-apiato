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

use App\Containers\AccountingSection\Contract\Foundation\Contract;
use App\Containers\AccountingSection\Contract\Models\Contract as ContractModel;
use App\Containers\CommunitySection\Counterparty\Models\Counterparty as CounterpartyModel;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\OrganizationBranch\Foundation\OrganizationBranch;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch as OrganizationBranchModel;
use App\Containers\CommunitySection\OrganizationClient\Foundation\OrganizationClient;
use App\Containers\CommunitySection\OrganizationClient\Models\OrganizationClient as OrganizationClientModel;
use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Containers\OrderSection\PaymentType\CashType;
use App\Containers\OrderSection\Status\Foundation\Status;
use App\Containers\OrderSection\Status\Models\Status as StatusModel;
use App\Containers\ShiftSection\Shift\Models\Shift as ShiftModel;
use App\Ship\Database\Eloquent\Collection;
use App\Ship\Parents\Factories\Factory;
use App\Ship\Traits\Factory\HasTrashedState;
use Illuminate\Database\Eloquent\Model;

/**
 * @method Collection|OrderModel create($attributes = [], ?Model $parent = null)
 * @method Collection|OrderModel make($attributes = [], ?Model $parent = null)
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
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
            Order::ORGANIZATION_BRANCH_ID => null,
            Order::COUNTERPARTY_ID => null,
            Order::CONTRACT_ID => null,
            Order::SHIFT_ID => null,
            Order::COMMENT => $this->faker->text(50),
            Order::ORGANIZATION_ID => $organization->id,
            Order::PAYMENT_TYPE => CashType::class,
            Order::TOTAL => ZERO,
            Order::PROFIT => ZERO
        ];
    }

    public function organizationBranch(mixed $branch = null): self
    {
        if ($branch instanceof OrganizationBranchModel) {
            $branch = $branch->id;
        }

        return $this->state(function (array $state) use ($branch) {
            if (array_key_exists(Order::ORGANIZATION_ID, $state) && is_null($branch)) {
                $organizationBranch = OrganizationBranchModel::factory()
                    ->create([
                        OrganizationBranch::ORGANIZATION_ID => $state[Order::ORGANIZATION_ID]
                    ]);

                $branch = $organizationBranch->id;
            }

            return [
                Order::ORGANIZATION_BRANCH_ID => $branch
            ];
        });
    }

    /**
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function organization(int $id): self
    {
        return $this->state(fn() => [
            Order::ORGANIZATION_ID => $id
        ]);
    }

    public function contract(?ContractModel $contract = null): self
    {
        return $this->state(function (array $state) use ($contract) {
            if (is_null($contract)) {
                $counterparty = CounterpartyModel::factory()
                    ->organization($state[Order::ORGANIZATION_ID])
                    ->create();

                $contract = ContractModel::factory()
                    ->create([
                        Contract::COUNTERPARTY_ID => $counterparty->id,
                        Contract::ORGANIZATION_ID => $counterparty->organization_id
                    ]);
            }

            return [
                Order::CLIENT_ID => null,
                Order::CONTRACT_ID => $contract->id,
                Order::COUNTERPARTY_ID => $contract->counterparty_id,
                Order::ORGANIZATION_ID => $contract->organization_id
            ];
        });
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

    public function shift(): self
    {
        $shift = ShiftModel::factory()->create();

        return $this->state(fn() => [
            Order::SHIFT_ID => $shift->id
        ]);
    }
}
