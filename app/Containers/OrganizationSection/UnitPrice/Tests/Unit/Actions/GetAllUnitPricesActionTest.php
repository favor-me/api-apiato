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

namespace App\Containers\OrganizationSection\UnitPrice\Tests\Unit\Actions;

use App\Containers\OrganizationSection\UnitPrice\Actions\GetAllUnitPricesAction;
use App\Containers\OrganizationSection\UnitPrice\Models\UnitPrice as UnitPriceModel;
use App\Containers\OrganizationSection\UnitPrice\Tests\UnitTestCase;
use Illuminate\Pagination\LengthAwarePaginator;

final class GetAllUnitPricesActionTest extends UnitTestCase
{
    public function test(): void
    {
        $models = UnitPriceModel::factory()
            ->count(10)
            ->create();

        $result = app(GetAllUnitPricesAction::class)->run();

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertSame($models->count(), $result->count());
    }

    public function testOnlyTrashed(): void
    {
        UnitPriceModel::factory()
            ->count(4)
            ->create();

        UnitPriceModel::factory()
            ->trashed()
            ->create();

        $result = app(GetAllUnitPricesAction::class)->run(true);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertSame(1, $result->total());
    }
}
