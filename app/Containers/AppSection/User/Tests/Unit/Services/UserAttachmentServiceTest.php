<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 */

namespace App\Containers\AppSection\User\Tests\Unit\Services;

use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\AppSection\User\Services\UserAttachmentService;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use App\Ship\Utils\Str;

final class UserAttachmentServiceTest extends UnitTestCase
{
    public function testGetUploadBasePath(): void
    {
        /** @var UserModel $user */
        $user = UserModel::factory()
            ->count(10)
            ->create()
            ->last();

        $this->assertSame(
            Str::toPath($user->id) . '/u' . $user->id,
            (new UserAttachmentService($user))->getUploadBasePath()
        );
    }
}
