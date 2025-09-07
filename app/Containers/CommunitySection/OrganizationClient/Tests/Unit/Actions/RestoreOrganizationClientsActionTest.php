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

use App\Containers\CommunitySection\OrganizationClient\Actions\RestoreOrganizationClientsAction;
use App\Containers\CommunitySection\OrganizationClient\Models\OrganizationClient as OrganizationClientModel;
use App\Containers\CommunitySection\OrganizationClient\Tests\UnitTestCase;
use Illuminate\Support\Carbon;

final class RestoreOrganizationClientsActionTest extends UnitTestCase
{
    public function testNotTrashed(): void
    {
        $model = OrganizationClientModel::factory()->create();
        $this->assertSame(ZERO, app(RestoreOrganizationClientsAction::class)->run([$model->id]));
    }

    public function testTrashed(): void
    {
        $model = OrganizationClientModel::factory()
            ->trashed()
            ->create();

        $this->assertInstanceOf(Carbon::class, $model->deleted_at);

        $this->assertSame(1, app(RestoreOrganizationClientsAction::class)->run([$model->id]));

        $model->refresh();

        $this->assertNull($model->deleted_at);
    }
}
