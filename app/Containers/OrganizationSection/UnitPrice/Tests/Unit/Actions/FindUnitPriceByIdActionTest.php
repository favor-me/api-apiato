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

use App\Containers\OrganizationSection\UnitPrice\Actions\FindUnitPriceByIdAction;
use App\Containers\OrganizationSection\UnitPrice\Models\UnitPrice as UnitPriceModel;
use App\Containers\OrganizationSection\UnitPrice\Tests\UnitTestCase;
use App\Ship\Exceptions\NotFoundException;

final class FindUnitPriceByIdActionTest extends UnitTestCase
{
    public function testWithInvalidId(): void
    {
        $this->getTestingOrganizationUser();

        $this->expectException(NotFoundException::class);
        app(FindUnitPriceByIdAction::class)->run(2131243);
    }

    public function testWithActualId(): void
    {
        $this->getTestingOrganizationUser();

        $model = UnitPriceModel::factory()->create();

        $this->assertInstanceOf(
            UnitPriceModel::class,
            app(FindUnitPriceByIdAction::class)->run($model->id)
        );
    }
}
