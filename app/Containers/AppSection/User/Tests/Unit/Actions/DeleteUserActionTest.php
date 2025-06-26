<?php

/**
 * Beauty application system
 *
 * This file is part of the Beauty application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     Proprietary
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved.
 * @link        https://kalistratov.ru
 */

namespace App\Containers\AppSection\User\Tests\Unit\Actions;

use App\Containers\AppSection\User\Actions\DeleteUserAction;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use App\Ship\Exceptions\DeleteResourceFailedException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class DeleteUserActionTest extends UnitTestCase
{
    public function testFailedId(): void
    {
        $this->expectException(DeleteResourceFailedException::class);
        $this->expectExceptionMessage(__('ship::exception.no_resources_found_to_delete'));
        $this->expectExceptionCode(Response::HTTP_EXPECTATION_FAILED);

        Config::set('app.debug', true);

        app(DeleteUserAction::class)->run([123123]);
    }

    public function testSuccess(): void
    {
        $user = User::factory()->create();
        $result = app(DeleteUserAction::class)->run([$user->id]);
        $this->assertSame(1, $result);

        $record = DB::table($user->getTable())->where(['id' => $user->id])->get()->first();
        $this->assertNotNull($record->deleted_at);
    }

    public function testDeleteOnlySuperAdminEnableDebug(): void
    {
        $this->expectException(DeleteResourceFailedException::class);
        $this->expectExceptionMessage(__('ship::exception.unable_to_remove_superuser'));
        $this->expectExceptionCode(Response::HTTP_EXPECTATION_FAILED);

        Config::set('app.debug', true);

        $superUser = $this->getSuperUser();

        app(DeleteUserAction::class)->run([$superUser->id]);
    }

    public function testDeleteSuperAdminAndAnyUserEnableDebug(): void
    {
        $this->expectException(DeleteResourceFailedException::class);
        $this->expectExceptionMessage(__('ship::exception.unable_to_remove_superuser'));
        $this->expectExceptionCode(Response::HTTP_EXPECTATION_FAILED);

        Config::set('app.debug', true);

        $superUser = $this->getSuperUser();
        $user = User::factory()->create();

        app(DeleteUserAction::class)->run([
            $superUser->id,
            $user->id
        ]);
    }

    public function testDeleteOnlySuperAdminDisableDebug(): void
    {
        $this->expectException(DeleteResourceFailedException::class);
        $this->expectExceptionMessage(__('ship::exception.failed_delete_resource'));
        $this->expectExceptionCode(Response::HTTP_EXPECTATION_FAILED);

        Config::set('app.debug', false);

        $superUser = $this->getSuperUser();

        app(DeleteUserAction::class)->run([$superUser->id]);
    }

    public function testDeleteSuperAdminAndAnyUserDisableDebug(): void
    {
        $this->expectException(DeleteResourceFailedException::class);
        $this->expectExceptionMessage(__('ship::exception.failed_delete_resource'));
        $this->expectExceptionCode(Response::HTTP_EXPECTATION_FAILED);

        Config::set('app.debug', false);

        $superUser = $this->getSuperUser();
        $user = User::factory()->create();

        app(DeleteUserAction::class)->run([
            $superUser->id,
            $user->id
        ]);
    }
}
