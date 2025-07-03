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

namespace App\Containers\CommunitySection\OrganizationBranch\Tests\Unit\Actions;

use App\Containers\CommunitySection\OrganizationBranch\Actions\GetAllOrganizationBranchesAction;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch as OrganizationBranchModel;
use App\Containers\CommunitySection\OrganizationBranch\Tests\UnitTestCase;
use Illuminate\Pagination\LengthAwarePaginator;

final class GetAllOrganizationBranchesActionTest extends UnitTestCase
{
    public function test(): void
    {
        $models = OrganizationBranchModel::factory()
            ->count(10)
            ->create();

        $result = app(GetAllOrganizationBranchesAction::class)->run();

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertSame($models->count(), $result->count());
    }

    public function testOnlyTrashed(): void
    {
        OrganizationBranchModel::factory()
            ->count(4)
            ->create();

        OrganizationBranchModel::factory()
            ->trashed()
            ->create();

        $result = app(GetAllOrganizationBranchesAction::class)->run(true);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertSame(1, $result->total());
    }
}
