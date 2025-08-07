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

use App\Containers\CommunitySection\OrganizationUnit\Actions\FindOrganizationUnitByIdAction;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Containers\CommunitySection\OrganizationUnit\Tests\UnitTestCase;
use App\Ship\Exceptions\NotFoundException;

final class FindOrganizationUnitByIdActionTest extends UnitTestCase
{
    public function testWithInvalidId(): void
    {
        $this->expectException(NotFoundException::class);
        app(FindOrganizationUnitByIdAction::class)->run(2131243);
    }

    public function testWithActualId(): void
    {
        $model = OrganizationUnitModel::factory()->create();

        $this->assertInstanceOf(
            OrganizationUnitModel::class,
            app(FindOrganizationUnitByIdAction::class)->run($model->id)
        );
    }
}
