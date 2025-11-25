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

use App\Containers\OrganizationSection\UnitPrice\Actions\RestoreUnitPricesAction;
use App\Containers\OrganizationSection\UnitPrice\Models\UnitPrice as UnitPriceModel;
use App\Containers\OrganizationSection\UnitPrice\Tests\UnitTestCase;
use Illuminate\Support\Carbon;

final class RestoreUnitPricesActionTest extends UnitTestCase
{
    public function testNotTrashed(): void
    {
        $model = UnitPriceModel::factory()->create();
        $this->assertSame(ZERO, app(RestoreUnitPricesAction::class)->run([$model->id]));
    }

    public function testTrashed(): void
    {
        $model = UnitPriceModel::factory()
            ->trashed()
            ->create();

        $this->assertInstanceOf(Carbon::class, $model->deleted_at);

        $this->assertSame(1, app(RestoreUnitPricesAction::class)->run([$model->id]));

        $model->refresh();

        $this->assertNull($model->deleted_at);
    }
}
