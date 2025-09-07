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

use App\Containers\CommunitySection\OrganizationClient\Actions\TrashOrganizationClientsAction;
use App\Containers\CommunitySection\OrganizationClient\Models\OrganizationClient as OrganizationClientModel;
use App\Containers\CommunitySection\OrganizationClient\Tests\UnitTestCase;

final class TrashOrganizationClientsActionTest extends UnitTestCase
{
    public function testSuccess(): void
    {
        $models = OrganizationClientModel::factory()
            ->count(10)
            ->create();

        $ids = $models->pluck(ID);

        $result = app(TrashOrganizationClientsAction::class)->run($ids->toArray());

        $this->assertSame($models->count(), $result);

        $models
            ->each(function (OrganizationClientModel $model) {
                $model->refresh();
                $this->assertSoftDeleted(OrganizationClientModel::TABLE, [ID => $model->id]);
            });
    }
}
