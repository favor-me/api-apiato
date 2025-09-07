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

namespace App\Containers\CommunitySection\OrganizationClient\Tests\Unit\Actions;

use App\Containers\CommunitySection\OrganizationClient\Actions\UpdateOrganizationClientAction;
use App\Containers\CommunitySection\OrganizationClient\Dto\UpdateOrganizationClientDto;
use App\Containers\CommunitySection\OrganizationClient\Models\OrganizationClient as OrganizationClientModel;
use App\Containers\CommunitySection\OrganizationClient\Tests\UnitTestCase;
use App\Ship\Exceptions\UpdateResourceFailedException;

final class UpdateOrganizationClientActionTest extends UnitTestCase
{
    public function testFail(): void
    {
        $this->expectException(UpdateResourceFailedException::class);
        $data = OrganizationClientModel::factory()
            ->make([
                ID => 123123
            ]);

        $dto = new UpdateOrganizationClientDto($data->toArray());
        app(UpdateOrganizationClientAction::class)->run($dto);
    }

    public function testSuccess(): void
    {
        $model = OrganizationClientModel::factory()->create();
        $this->assertInstanceOf(OrganizationClientModel::class, $model);

        $data = OrganizationClientModel::factory()
            ->make([
                ID => $model->id,
                //  write more.
            ]);

        $dto = new UpdateOrganizationClientDto($data->toArray());

        $result = app(UpdateOrganizationClientAction::class)->run($dto);

        $this->assertInstanceOf(OrganizationClientModel::class, $result);
    }
}
