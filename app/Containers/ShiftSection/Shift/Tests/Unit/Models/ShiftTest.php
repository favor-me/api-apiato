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

namespace App\Containers\ShiftSection\Shift\Tests\Unit\Models;

use App\Containers\AppSection\User\Models\User;
use App\Containers\CommunitySection\Organization\Models\Organization;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch;
use App\Containers\ShiftSection\Item\Foundation\Item;
use App\Containers\ShiftSection\Item\Models\Item as ItemModel;
use App\Containers\ShiftSection\ItemType\AwardType;
use App\Containers\ShiftSection\ItemType\FineType;
use App\Containers\ShiftSection\ItemType\IncomeType;
use App\Containers\ShiftSection\Shift\Foundation\Shift;
use App\Containers\ShiftSection\Shift\Models\Shift as ShiftModel;
use App\Containers\ShiftSection\Shift\Statuses\CompletedStatus;
use App\Containers\ShiftSection\Shift\Statuses\OpenStatus;
use App\Containers\ShiftSection\Shift\Tests\UnitTestCase;
use App\Ship\Database\Eloquent\Collection;
use App\Ship\SimpleTypes\Type\Money;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
final class ShiftTest extends UnitTestCase
{
    protected ?ShiftModel $model;

    public function setUp(): void
    {
        parent::setUp();
        $this->model = ShiftModel::factory()->make();
    }

    public function testInstance(): void
    {
        $this->assertInstanceOf(ShiftModel::class, $this->model);
    }

    public function testTableName(): void
    {
        $this->assertSame(ShiftModel::TABLE, $this->model->getTable());
    }

    public function testTimestamp(): void
    {
        $this->assertTrue($this->model->timestamps);
    }

    public function testGetResourceKey(): void
    {
        $this->assertSame(ShiftModel::RESOURCE_KEY, $this->model->getResourceKey());
    }

    public function testFillable(): void
    {
        $this->assertSame([
            Shift::ORGANIZATION_ID,
            Shift::ORGANIZATION_BRANCH_ID,
            Shift::START_AT,
            Shift::FINISH_AT,
            Shift::MONEY,
            Shift::CONFIRMED_BY,
            Shift::CONFIRMED_AT,
            Shift::PAYMENT_AT,
            CREATED_BY
        ], $this->model->getFillable());
    }

    public function testCasts(): void
    {
        $this->assertInstanceOf(Money::class, $this->model->money);
    }

    public function testBelongsToCreator(): void
    {
        $this->assertInstanceOf(BelongsTo::class, $this->model->creator());
        $this->assertInstanceOf(User::class, $this->model->creator()->getModel());
        $this->assertInstanceOf(User::class, $this->model->creator);
    }

    public function testBelongsToOrganization(): void
    {
        $this->assertInstanceOf(BelongsTo::class, $this->model->organization());
        $this->assertInstanceOf(Organization::class, $this->model->organization()->getModel());
        $this->assertInstanceOf(Organization::class, $this->model->organization);
    }

    public function testBelongsToOrganizationBranch(): void
    {
        $this->assertInstanceOf(BelongsTo::class, $this->model->organizationBranch());
        $this->assertInstanceOf(OrganizationBranch::class, $this->model->organizationBranch()->getModel());
        $this->assertInstanceOf(OrganizationBranch::class, $this->model->organizationBranch);
    }

    public function testOpenStatus(): void
    {
        $startAt = now()->utc()->subHours(3);
        $finishAt = now()->utc()->addHours(3);

        $shift = ShiftModel::factory()
            ->make([
                Shift::START_AT => $startAt,
                Shift::FINISH_AT => $finishAt
            ]);

        $this->assertInstanceOf(OpenStatus::class, $shift->status);
    }

    public function testCompletedStatus(): void
    {
        $startAt = now()->utc()->subHours(8);
        $finishAt = now()->utc()->subHours(1);

        $shift = ShiftModel::factory()
            ->make([
                Shift::START_AT => $startAt,
                Shift::FINISH_AT => $finishAt
            ]);

        $this->assertInstanceOf(CompletedStatus::class, $shift->status);
    }

    public function testHasManyItems(): void
    {
        $startAt = now()->utc()->subHours(8);
        $finishAt = now()->utc()->subHours(1);

        $shift = ShiftModel::factory()
            ->create([
                Shift::START_AT => $startAt,
                Shift::FINISH_AT => $finishAt
            ]);

        ItemModel::factory()
            ->create([
                Item::SHIFT_ID => $shift->id
            ]);

        $this->assertInstanceOf(HasMany::class, $shift->items());
        $this->assertInstanceOf(ItemModel::class, $shift->items()->getModel());
        $this->assertInstanceOf(Collection::class, $shift->items);
        $this->assertCount(1, $shift->items);
    }

    public function testCalculate(): void
    {
        $startAt = now()->utc()->subHours(7);
        $finishAt = now()->utc()->subHours(1);

        $shift = ShiftModel::factory()
            ->create([
                Shift::START_AT => $startAt,
                Shift::FINISH_AT => $finishAt
            ]);

        $itemA = ItemModel::factory()
            ->create([
                Item::VALUE => 1000,
                Item::TYPE => IncomeType::class,
                Item::SHIFT_ID => $shift->id
            ]);

        $itemB = ItemModel::factory()
            ->create([
                Item::VALUE => 2000,
                Item::TYPE => AwardType::class,
                Item::SHIFT_ID => $shift->id
            ]);

        $itemC = ItemModel::factory()
            ->create([
                Item::VALUE => 500,
                Item::TYPE => FineType::class,
                Item::SHIFT_ID => $shift->id
            ]);

        $shift->calculate();

        $shiftMoney = app('money')
            ->add($itemA->value)
            ->add($itemB->value)
            ->add($itemC->value->negative());

        $this->assertSame($shiftMoney->val(), $shift->money->val());
    }
}
