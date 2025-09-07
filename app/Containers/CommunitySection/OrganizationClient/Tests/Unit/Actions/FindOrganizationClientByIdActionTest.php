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

namespace App\Containers\CommunitySection\OrganizationClient\Tests\Unit\Actions;

use App\Containers\CommunitySection\OrganizationClient\Actions\FindOrganizationClientByIdAction;
use App\Containers\CommunitySection\OrganizationClient\Models\OrganizationClient as OrganizationClientModel;
use App\Containers\CommunitySection\OrganizationClient\Tests\UnitTestCase;
use App\Ship\Exceptions\NotFoundException;

final class FindOrganizationClientByIdActionTest extends UnitTestCase
{
    public function testWithInvalidId(): void
    {
        $this->expectException(NotFoundException::class);
        app(FindOrganizationClientByIdAction::class)->run(2131243);
    }

    public function testWithActualId(): void
    {
        $model = OrganizationClientModel::factory()->create();

        $this->assertInstanceOf(
            OrganizationClientModel::class,
            app(FindOrganizationClientByIdAction::class)->run($model->id)
        );
    }
}
