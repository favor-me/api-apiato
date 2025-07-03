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

use App\Containers\CommunitySection\OrganizationBranch\Actions\TrashOrganizationBranchesAction;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch as OrganizationBranchModel;
use App\Containers\CommunitySection\OrganizationBranch\Tests\UnitTestCase;

final class TrashOrganizationBranchesActionTest extends UnitTestCase
{
    public function testSuccess(): void
    {
        $models = OrganizationBranchModel::factory()
            ->count(10)
            ->create();

        $ids = $models->pluck(ID);

        $result = app(TrashOrganizationBranchesAction::class)->run($ids->toArray());

        $this->assertSame($models->count(), $result);

        $models
            ->each(function (OrganizationBranchModel $model) {
                $model->refresh();
                $this->assertSoftDeleted(OrganizationBranchModel::TABLE, [ID => $model->id]);
            });
    }
}
