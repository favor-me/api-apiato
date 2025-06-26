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

namespace App\Containers\CommunitySection\Organization\Tests\Unit\Actions;

use App\Containers\CommunitySection\Organization\Actions\CreateOrganizationAction;
use App\Containers\CommunitySection\Organization\Dto\CreateOrganizationDto;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\Organization\Tests\UnitTestCase;

final class CreateOrganizationActionTest extends UnitTestCase
{
    public function testSuccess(): void
    {
        $data = OrganizationModel::factory()->make();
        $dto = new CreateOrganizationDto($data->toArray());

        $result = app(CreateOrganizationAction::class)->run($dto);

        $this->assertInstanceOf(OrganizationModel::class, $result);
    }
}
