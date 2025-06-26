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

use App\Containers\CommunitySection\Organization\Actions\UpdateOrganizationAction;
use App\Containers\CommunitySection\Organization\Dto\UpdateOrganizationDto;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\Organization\Tests\UnitTestCase;
use App\Ship\Exceptions\UpdateResourceFailedException;

final class UpdateOrganizationActionTest extends UnitTestCase
{
    public function testFail(): void
    {
        $this->expectException(UpdateResourceFailedException::class);
        $data = OrganizationModel::factory()
            ->make([
                ID => 123123
            ]);

        $dto = new UpdateOrganizationDto($data->toArray());
        app(UpdateOrganizationAction::class)->run($dto);
    }

    public function testSuccess(): void
    {
        $model = OrganizationModel::factory()->create();
        $this->assertInstanceOf(OrganizationModel::class, $model);

        $data = OrganizationModel::factory()
            ->make([
                ID => $model->id,
                //  write more.
            ]);

        $dto = new UpdateOrganizationDto($data->toArray());

        $result = app(UpdateOrganizationAction::class)->run($dto);

        $this->assertInstanceOf(OrganizationModel::class, $result);
    }
}
