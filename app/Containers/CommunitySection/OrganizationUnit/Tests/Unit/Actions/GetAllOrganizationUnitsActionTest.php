<?php

/**
 * __PROJECT_NAME__
 *
 * This file is part of the __PROJECT_NAME__ package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license __PROJECT_LICENCE__
 * @copyright Copyright (C) __PROJECT_AUTHOR__, All rights reserved ©.
 * @link __PROJECT_URL__
 * @author __PROJECT_AUTHOR__ <__PROJECT_AUTHOR__EMAIL__>
 */

namespace App\Containers\CommunitySection\OrganizationUnit\Tests\Unit\Actions;

use App\Containers\CommunitySection\OrganizationUnit\Actions\GetAllOrganizationUnitsAction;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\CommunitySection\OrganizationUnit\Tests\UnitTestCase;
use Illuminate\Pagination\LengthAwarePaginator;

final class GetAllOrganizationUnitsActionTest extends UnitTestCase
{
    public function test(): void
    {
        $models = OrganizationUnitModel::factory()
            ->count(10)
            ->create();

        $result = app(GetAllOrganizationUnitsAction::class)->run();

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertSame($models->count(), $result->count());
    }

    public function testOnlyTrashed(): void
    {
        OrganizationUnitModel::factory()
            ->count(4)
            ->create();

        OrganizationUnitModel::factory()
            ->trashed()
            ->create();

        $result = app(GetAllOrganizationUnitsAction::class)->run(true);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertSame(1, $result->total());
    }
}
