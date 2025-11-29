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

use App\Containers\OrganizationSection\UnitPrice\Actions\DeleteUnitPricesAction;
use App\Containers\OrganizationSection\UnitPrice\Models\UnitPrice as UnitPriceModel;
use App\Containers\OrganizationSection\UnitPrice\Tests\UnitTestCase;

final class DeleteUnitPricesActionTest extends UnitTestCase
{
    public function testTrashed(): void
    {
        $this->getTestingOrganizationUser();

        $models = UnitPriceModel::factory()
            ->count(2)
            ->create();

        $result = app(DeleteUnitPricesAction::class)
            ->run(
                $models
                    ->pluck(ID)
                    ->toArray()
            );

        $this->assertSame($models->count(), $result);
    }
}
