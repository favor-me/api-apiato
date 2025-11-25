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

use App\Containers\OrganizationSection\UnitPrice\Actions\GetTotalUnitPricesAction;
use App\Containers\OrganizationSection\UnitPrice\Models\UnitPrice as UnitPriceModel;
use App\Containers\OrganizationSection\UnitPrice\Tests\UnitTestCase;

final class GetTotalUnitPricesActionTest extends UnitTestCase
{
    public function test(): void
    {
        $models = UnitPriceModel::factory()
            ->count(8)
            ->create();

        $this->assertTrue(app(GetTotalUnitPricesAction::class)->run() >= $models->count());
    }
}
