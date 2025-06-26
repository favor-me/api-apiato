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

namespace App\Containers\CommunitySection\Organization\Tests\Unit\Actions;

use App\Containers\CommunitySection\Organization\Actions\FindOrganizationByIdAction;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\Organization\Tests\UnitTestCase;
use App\Ship\Exceptions\NotFoundException;

final class FindOrganizationByIdActionTest extends UnitTestCase
{
    public function testWithInvalidId(): void
    {
        $this->expectException(NotFoundException::class);
        app(FindOrganizationByIdAction::class)->run(2131243);
    }

    public function testWithActualId(): void
    {
        $model = OrganizationModel::factory()->create();

        $this->assertInstanceOf(
            OrganizationModel::class,
            app(FindOrganizationByIdAction::class)->run($model->id)
        );
    }
}
