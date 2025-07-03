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

use App\Containers\CommunitySection\OrganizationBranch\Actions\CreateOrganizationBranchAction;
use App\Containers\CommunitySection\OrganizationBranch\Dto\CreateOrganizationBranchDto;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch as OrganizationBranchModel;
use App\Containers\CommunitySection\OrganizationBranch\Tests\UnitTestCase;

final class CreateOrganizationBranchActionTest extends UnitTestCase
{
    public function testSuccess(): void
    {
        $data = OrganizationBranchModel::factory()->make();
        $dto = new CreateOrganizationBranchDto($data->toArray());

        $result = app(CreateOrganizationBranchAction::class)->run($dto);

        $this->assertInstanceOf(OrganizationBranchModel::class, $result);
    }
}
