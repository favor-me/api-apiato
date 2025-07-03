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

use App\Containers\CommunitySection\OrganizationBranch\Actions\FindOrganizationBranchByIdAction;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch as OrganizationBranchModel;
use App\Containers\CommunitySection\OrganizationBranch\Tests\UnitTestCase;
use App\Ship\Exceptions\NotFoundException;

final class FindOrganizationBranchByIdActionTest extends UnitTestCase
{
    public function testWithInvalidId(): void
    {
        $this->expectException(NotFoundException::class);
        app(FindOrganizationBranchByIdAction::class)->run(2131243);
    }

    public function testWithActualId(): void
    {
        $model = OrganizationBranchModel::factory()->create();

        $this->assertInstanceOf(
            OrganizationBranchModel::class,
            app(FindOrganizationBranchByIdAction::class)->run($model->id)
        );
    }
}
