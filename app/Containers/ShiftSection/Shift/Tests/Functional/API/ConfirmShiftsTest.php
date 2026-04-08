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

namespace App\Containers\ShiftSection\Shift\Tests\Functional\API;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\ShiftSection\Shift\Facades\Container;
use App\Containers\ShiftSection\Shift\Models\Shift as ShiftModel;
use App\Containers\ShiftSection\Shift\Tests\Functional\ApiTestCase;
use Illuminate\Support\Carbon;
use Illuminate\Testing\Fluent\AssertableJson;

final class ConfirmShiftsTest extends ApiTestCase
{
    protected array $access = [
        ROLES => Role::ORGANIZATION_OWNER
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->endpoint = 'patch@v1/' . Container::getApiUri('confirm');
    }

    public function testSuccess(): void
    {
        $this->getTestingOrganizationOwnerUser();

        $shift = ShiftModel::factory()->create();

        $this->makeCall([
            'ids' => $shift->getHashedKey()
        ]);

        $this->response
            ->assertOk()
            ->assertJson(
                fn(AssertableJson $json): AssertableJson => $json
                    ->has(MESSAGE)
                    ->where(MESSAGE, Container::transMultipleConfirmed(1))
                    ->etc()
            );

        $shift->refresh();

        $this->assertInstanceOf(Carbon::class, $shift->confirmed_at);
    }
}
