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

use App\Containers\CommunitySection\OrganizationUnit\Actions\UpdateOrganizationUnitAction;
use App\Containers\CommunitySection\OrganizationUnit\Dto\UpdateOrganizationUnitDto;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\CommunitySection\OrganizationUnit\Tests\UnitTestCase;
use App\Ship\Exceptions\UpdateResourceFailedException;

final class UpdateOrganizationUnitActionTest extends UnitTestCase
{
    public function testFail(): void
    {
        $this->expectException(UpdateResourceFailedException::class);
        $data = OrganizationUnitModel::factory()
            ->make([
                ID => 123123
            ]);

        $dto = new UpdateOrganizationUnitDto($data->toArray());
        app(UpdateOrganizationUnitAction::class)->run($dto);
    }

    public function testSuccess(): void
    {
        $model = OrganizationUnitModel::factory()->create();
        $this->assertInstanceOf(OrganizationUnitModel::class, $model);

        $data = OrganizationUnitModel::factory()
            ->make([
                ID => $model->id,
                //  write more.
            ]);

        $dto = new UpdateOrganizationUnitDto($data->toArray());

        $result = app(UpdateOrganizationUnitAction::class)->run($dto);

        $this->assertInstanceOf(OrganizationUnitModel::class, $result);
    }
}
