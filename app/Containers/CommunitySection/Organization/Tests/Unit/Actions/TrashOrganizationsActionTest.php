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

use App\Containers\CommunitySection\Organization\Actions\TrashOrganizationsAction;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\Organization\Tests\UnitTestCase;

final class TrashOrganizationsActionTest extends UnitTestCase
{
    public function testSuccess(): void
    {
        $models = OrganizationModel::factory()
            ->count(10)
            ->create();

        $ids = $models->pluck(ID);

        $result = app(TrashOrganizationsAction::class)->run($ids->toArray());

        $this->assertSame($models->count(), $result);

        $models
            ->each(function (OrganizationModel $model) {
                $model->refresh();
                $this->assertSoftDeleted(OrganizationModel::TABLE, [ID => $model->id]);
            });
    }
}
