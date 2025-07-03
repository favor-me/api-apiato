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

use App\Containers\CommunitySection\OrganizationBranch\Actions\DeleteOrganizationBranchesAction;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch as OrganizationBranchModel;
use App\Containers\CommunitySection\OrganizationBranch\Tests\UnitTestCase;

final class DeleteOrganizationBranchesActionTest extends UnitTestCase
{
    public function testNotTrashed(): void
    {
        $model = OrganizationBranchModel::factory()->create();

        $result = app(DeleteOrganizationBranchesAction::class)->run([$model->id]);

        $this->assertSame(ZERO, $result);
    }

    public function testTrashed(): void
    {
        $models = OrganizationBranchModel::factory()
            ->count(2)
            ->trashed()
            ->create();

        $ids = $models
            ->pluck(ID)
            ->toArray();

        $result = app(DeleteOrganizationBranchesAction::class)->run($ids);

        $this->assertSame($models->count(), $result);
    }
}
