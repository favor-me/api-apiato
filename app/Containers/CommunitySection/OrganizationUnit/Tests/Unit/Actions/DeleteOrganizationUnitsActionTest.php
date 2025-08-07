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

use App\Containers\CommunitySection\OrganizationUnit\Actions\DeleteOrganizationUnitsAction;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\CommunitySection\OrganizationUnit\Tests\UnitTestCase;

final class DeleteOrganizationUnitsActionTest extends UnitTestCase
{
    public function testNotTrashed(): void
    {
        $model = OrganizationUnitModel::factory()->create();

        $result = app(DeleteOrganizationUnitsAction::class)->run([$model->id]);

        $this->assertSame(ZERO, $result);
    }

    public function testTrashed(): void
    {
        $models = OrganizationUnitModel::factory()
            ->count(2)
            ->trashed()
            ->create();

        $ids = $models
            ->pluck(ID)
            ->toArray();

        $result = app(DeleteOrganizationUnitsAction::class)->run($ids);

        $this->assertSame($models->count(), $result);
    }
}
