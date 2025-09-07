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

use App\Containers\CommunitySection\OrganizationClient\Actions\GetAllOrganizationClientsAction;
use App\Containers\CommunitySection\OrganizationClient\Models\OrganizationClient as OrganizationClientModel;
use App\Containers\CommunitySection\OrganizationClient\Tests\UnitTestCase;
use Illuminate\Pagination\LengthAwarePaginator;

final class GetAllOrganizationClientsActionTest extends UnitTestCase
{
    public function test(): void
    {
        $models = OrganizationClientModel::factory()
            ->count(10)
            ->create();

        $result = app(GetAllOrganizationClientsAction::class)->run();

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertSame($models->count(), $result->count());
    }

    public function testOnlyTrashed(): void
    {
        OrganizationClientModel::factory()
            ->count(4)
            ->create();

        OrganizationClientModel::factory()
            ->trashed()
            ->create();

        $result = app(GetAllOrganizationClientsAction::class)->run(true);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertSame(1, $result->total());
    }
}
