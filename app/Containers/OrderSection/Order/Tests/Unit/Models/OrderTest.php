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

namespace App\Containers\OrderSection\Order\Tests\Unit\Models;

use App\Containers\AccountingSection\Contract\Models\Contract;
use App\Containers\AppSection\User\Models\User;
use App\Containers\CommunitySection\Counterparty\Models\Counterparty;
use App\Containers\CommunitySection\Organization\Models\Organization;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch;
use App\Containers\CommunitySection\OrganizationClient\Models\OrganizationClient;
use App\Containers\OrderSection\Item\Collections\ItemEloquentCollection;
use App\Containers\OrderSection\Item\Models\Item as ItemModel;
use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Models\Order as OrderModel;
use App\Containers\OrderSection\Order\Tests\UnitTestCase;
use App\Containers\OrderSection\PaymentType\CashType;
use App\Containers\OrderSection\PaymentType\Type;
use App\Containers\OrderSection\Status\Foundation\Status;
use App\Containers\OrderSection\Status\Models\Status as StatusModel;
use App\Containers\OrganizationSection\Shift\Models\Shift as ShiftModel;
use App\Ship\SimpleTypes\Type\Money;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
final class OrderTest extends UnitTestCase
{
    protected ?OrderModel $model;

    public function setUp(): void
    {
        parent::setUp();
        $this->model = OrderModel::factory()->make();
    }

    public function testInstance(): void
    {
        $this->assertInstanceOf(OrderModel::class, $this->model);
    }

    public function testTableName(): void
    {
        $this->assertSame(OrderModel::TABLE, $this->model->getTable());
    }

    public function testTimestamp(): void
    {
        $this->assertTrue($this->model->timestamps);
    }

    public function testGetResourceKey(): void
    {
        $this->assertSame(OrderModel::RESOURCE_KEY, $this->model->getResourceKey());
    }

    public function testFillable(): void
    {
        $this->assertSame([
            Order::ORGANIZATION_ID,
            Order::ORGANIZATION_BRANCH_ID,
            Order::OID,
            Order::SHIFT_ID,
            Order::PAYMENT_TYPE,
            Order::TOTAL,
            Order::PROFIT,
            Order::COMMENT,
            Order::CLIENT_ID,
            Order::COUNTERPARTY_ID,
            Order::CONTRACT_ID,
            Order::STATUS_ID,
            Order::COMPLETED_AT,
            Order::CANCELED_AT,
        ], $this->model->getFillable());
    }

    public function testCasts(): void
    {
        $this->assertInstanceOf(Money::class, $this->model->total);
        $this->assertInstanceOf(Money::class, $this->model->profit);
        $this->assertInstanceOf(Type::class, $this->model->payment_type);
    }

    public function testBelongsToOrganization(): void
    {
        $order = OrderModel::factory()->create();

        $this->assertInstanceOf(BelongsTo::class, $order->organization());
        $this->assertInstanceOf(Organization::class, $order->organization()->getModel());
        $this->assertInstanceOf(Organization::class, $order->organization);
    }

    public function testBelongsToClient(): void
    {
        $order = OrderModel::factory()->create();

        $this->assertInstanceOf(BelongsTo::class, $order->client());
        $this->assertInstanceOf(OrganizationClient::class, $order->client()->getModel());
        $this->assertInstanceOf(OrganizationClient::class, $order->client);
    }

    public function testBelongsToUpdater(): void
    {
        $this->getTestingOrganizationUser();

        $order = OrderModel::factory()->create();

        $this->assertInstanceOf(BelongsTo::class, $order->updater());
        $this->assertInstanceOf(User::class, $order->updater()->getModel());
        $this->assertInstanceOf(User::class, $order->updater);
    }

    public function testBelongsToCreator(): void
    {
        $this->getTestingOrganizationUser();

        $order = OrderModel::factory()->create();

        $this->assertInstanceOf(BelongsTo::class, $order->creator());
        $this->assertInstanceOf(User::class, $order->creator()->getModel());
        $this->assertInstanceOf(User::class, $order->creator);
    }

    public function testBelongsToStatus(): void
    {
        $this->assertInstanceOf(BelongsTo::class, $this->model->status());
        $this->assertInstanceOf(StatusModel::class, $this->model->status()->getModel());

        $this->assertNull($this->model->status);

        $model = OrderModel::factory()
            ->for(StatusModel::factory())
            ->create();

        $this->assertInstanceOf(StatusModel::class, $model->status);
    }

    public function testSetCreatedByUpdatedByWithNotAuth(): void
    {
        $order = OrderModel::factory()->create();

        $this->assertNull($order->created_by);
        $this->assertNull($order->updated_by);
    }

    public function testSetOid(): void
    {
        $user = $this->getTestingOrganizationUser();

        $orderA = OrderModel::factory()
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id
            ]);

        $orderB = OrderModel::factory()->create();

        $orderAb = OrderModel::factory()
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id
            ]);

        $this->assertSame(1, $orderB->oid);

        $this->assertSame(1, $orderA->oid);
        $this->assertSame(2, $orderAb->oid);
    }

    public function testSetCompletedAtOnCreate(): void
    {
        $user = $this->getTestingOrganizationUser();

        $orderA = OrderModel::factory()
            ->completed()
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id
            ]);

        $this->assertInstanceOf(Carbon::class, $orderA->completed_at);

        $orderB = OrderModel::factory()
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id
            ]);

        $this->assertNull($orderB->completed_at);
    }

    public function testSetCompletedAtOnUpdate(): void
    {
        $user = $this->getTestingOrganizationUser();

        $orderA = OrderModel::factory()
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id
            ]);

        $this->assertNull($orderA->completed_at);

        $status = StatusModel::where(Status::SLUG, StatusModel::COMPLETED)->first();

        $orderA->setAttribute(Order::STATUS_ID, $status->id);
        $orderA->save();
        $orderA->refresh();

        $this->assertInstanceOf(Carbon::class, $orderA->completed_at);
    }

    public function testSetCanceledAtOnCreate(): void
    {
        $user = $this->getTestingOrganizationUser();

        $orderA = OrderModel::factory()
            ->canceled()
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id
            ]);

        $this->assertInstanceOf(Carbon::class, $orderA->canceled_at);

        $orderB = OrderModel::factory()
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id
            ]);

        $this->assertNull($orderB->canceled_at);
    }

    public function testSetCanceledAtOnUpdate(): void
    {
        $user = $this->getTestingOrganizationUser();

        $orderA = OrderModel::factory()
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id
            ]);

        $this->assertNull($orderA->canceled_at);

        $status = StatusModel::where(Status::SLUG, StatusModel::CANCELED)->first();

        $orderA->setAttribute(Order::STATUS_ID, $status->id);
        $orderA->save();
        $orderA->refresh();

        $this->assertInstanceOf(Carbon::class, $orderA->canceled_at);
    }

    public function testSetCreatedByUpdatedByWithAuth(): void
    {
        $user = $this->getTestingOrganizationUser();

        $order = OrderModel::factory()
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id
            ]);

        $this->assertSame($user->id, $order->created_by);
        $this->assertSame($user->id, $order->updated_by);
    }

    public function testHasManyItems(): void
    {
        $user = $this->getTestingOrganizationUser();

        $order = OrderModel::factory()
            ->create([
                Order::ORGANIZATION_ID => $user->organization_id
            ]);

        ItemModel::factory()->create();

        $items = ItemModel::factory()
            ->count(3)
            ->order($order)
            ->create();

        $this->assertInstanceOf(HasMany::class, $order->items());
        $this->assertInstanceOf(ItemEloquentCollection::class, $order->items);
        $this->assertCount($items->count(), $order->items);
    }

    public function testBelongsToContract(): void
    {
        $user = $this->getTestingOrganizationUser();

        $order = OrderModel::factory()
            ->organization($user->organization_id)
            ->contract()
            ->create();

        $this->assertInstanceOf(BelongsTo::class, $order->contract());
        $this->assertInstanceOf(Contract::class, $order->contract()->getModel());
        $this->assertInstanceOf(Contract::class, $order->contract);
    }

    public function testBelongsToCounterparty(): void
    {
        $user = $this->getTestingOrganizationUser();

        $order = OrderModel::factory()
            ->organization($user->organization_id)
            ->contract()
            ->create();

        $this->assertInstanceOf(BelongsTo::class, $order->counterparty());
        $this->assertInstanceOf(Counterparty::class, $order->counterparty()->getModel());
        $this->assertInstanceOf(Counterparty::class, $order->counterparty);
    }

    public function testPaymentTypeIs(): void
    {
        $orderA = OrderModel::factory()
            ->make([
                Order::PAYMENT_TYPE => CashType::class
            ]);

        $this->assertTrue($orderA->paymentTypeIs(CashType::class));
        $this->assertTrue($orderA->paymentTypeIs('cash'));
    }

    public function testBelongsToOrganizationBranch(): void
    {
        $user = $this->getTestingOrganizationUser();

        $order = OrderModel::factory()
            ->organization($user->organization_id)
            ->organizationBranch()
            ->create();

        $this->assertInstanceOf(BelongsTo::class, $order->organizationBranch());
        $this->assertInstanceOf(OrganizationBranch::class, $order->organizationBranch()->getModel());
        $this->assertInstanceOf(OrganizationBranch::class, $order->organizationBranch);
    }

    public function testBelongsToShift(): void
    {
        $user = $this->getTestingOrganizationUser();

        $order = OrderModel::factory()
            ->organization($user->organization_id)
            ->organizationBranch()
            ->shift()
            ->create();

        $this->assertInstanceOf(BelongsTo::class, $order->shift());
        $this->assertInstanceOf(ShiftModel::class, $order->shift()->getModel());
        $this->assertInstanceOf(ShiftModel::class, $order->shift);
    }
}
