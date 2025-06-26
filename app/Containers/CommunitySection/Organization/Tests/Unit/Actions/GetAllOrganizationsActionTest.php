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

use App\Containers\CommunitySection\Organization\Actions\GetAllOrganizationsAction;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\Organization\Tests\UnitTestCase;
use Illuminate\Pagination\LengthAwarePaginator;

final class GetAllOrganizationsActionTest extends UnitTestCase
{
    public function test(): void
    {
        $models = OrganizationModel::factory()
            ->count(10)
            ->create();

        $result = app(GetAllOrganizationsAction::class)->run();

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertSame($models->count(), $result->count());
    }

    public function testOnlyTrashed(): void
    {
        OrganizationModel::factory()
            ->count(4)
            ->create();

        OrganizationModel::factory()
            ->trashed()
            ->create();

        $result = app(GetAllOrganizationsAction::class)->run(true);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertSame(1, $result->total());
    }
}
