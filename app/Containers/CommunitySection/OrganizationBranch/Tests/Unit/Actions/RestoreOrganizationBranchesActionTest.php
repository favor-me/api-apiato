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

use App\Containers\CommunitySection\OrganizationBranch\Actions\RestoreOrganizationBranchesAction;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch as OrganizationBranchModel;
use App\Containers\CommunitySection\OrganizationBranch\Tests\UnitTestCase;
use Illuminate\Support\Carbon;

final class RestoreOrganizationBranchesActionTest extends UnitTestCase
{
    public function testNotTrashed(): void
    {
        $model = OrganizationBranchModel::factory()->create();
        $this->assertSame(ZERO, app(RestoreOrganizationBranchesAction::class)->run([$model->id]));
    }

    public function testTrashed(): void
    {
        $model = OrganizationBranchModel::factory()
            ->trashed()
            ->create();

        $this->assertInstanceOf(Carbon::class, $model->deleted_at);

        $this->assertSame(1, app(RestoreOrganizationBranchesAction::class)->run([$model->id]));

        $model->refresh();

        $this->assertNull($model->deleted_at);
    }
}
