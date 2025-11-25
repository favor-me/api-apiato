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

use App\Containers\OrganizationSection\UnitPrice\Actions\TrashUnitPricesAction;
use App\Containers\OrganizationSection\UnitPrice\Models\UnitPrice as UnitPriceModel;
use App\Containers\OrganizationSection\UnitPrice\Tests\UnitTestCase;

final class TrashUnitPricesActionTest extends UnitTestCase
{
    public function testSuccess(): void
    {
        $models = UnitPriceModel::factory()
            ->count(10)
            ->create();

        $ids = $models->pluck(ID);

        $result = app(TrashUnitPricesAction::class)->run($ids->toArray());

        $this->assertSame($models->count(), $result);

        $models
            ->each(function (UnitPriceModel $model) {
                $model->refresh();
                $this->assertSoftDeleted(UnitPriceModel::TABLE, [ID => $model->id]);
            });
    }
}
