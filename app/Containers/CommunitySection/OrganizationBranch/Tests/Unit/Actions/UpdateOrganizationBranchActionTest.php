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

use App\Containers\CommunitySection\OrganizationBranch\Actions\UpdateOrganizationBranchAction;
use App\Containers\CommunitySection\OrganizationBranch\Dto\UpdateOrganizationBranchDto;
use App\Containers\CommunitySection\OrganizationBranch\Foundation\OrganizationBranch;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch as OrganizationBranchModel;
use App\Containers\CommunitySection\OrganizationBranch\Tests\UnitTestCase;
use App\Ship\Exceptions\UpdateResourceFailedException;

final class UpdateOrganizationBranchActionTest extends UnitTestCase
{
    public function testFail(): void
    {
        $this->expectException(UpdateResourceFailedException::class);
        $data = OrganizationBranchModel::factory()
            ->make([
                ID => 123123
            ]);

        $dto = new UpdateOrganizationBranchDto($data->toArray());
        app(UpdateOrganizationBranchAction::class)->run($dto);
    }

    public function testSuccess(): void
    {
        $model = OrganizationBranchModel::factory()->create();
        $this->assertInstanceOf(OrganizationBranchModel::class, $model);

        $data = OrganizationBranchModel::factory()
            ->make([
                ID => $model->id,
                OrganizationBranch::NAME => 'New name'
            ]);

        $dto = new UpdateOrganizationBranchDto($data->toArray());

        $result = app(UpdateOrganizationBranchAction::class)->run($dto);

        $this->assertInstanceOf(OrganizationBranchModel::class, $result);
        $this->assertSame($data->name, $result->name);
    }
}
