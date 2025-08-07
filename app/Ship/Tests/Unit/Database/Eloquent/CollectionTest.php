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

namespace App\Ship\Tests\Unit\Database\Eloquent;

use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Ship\Tests\UnitTestCase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

final class CollectionTest extends UnitTestCase
{
    public function testHashedKeysWithDisableHashedIdMode(): void
    {
        Config::set('apiato.hash-id', false);

        $users = UserModel::factory()
            ->count(5)
            ->create();

        $ids = $users->getHashedKeys();

        $this->assertInstanceOf(Collection::class, $ids);
        $this->assertCount($users->count(), $ids);

        $users->each(
            fn(UserModel $user) => $this->assertTrue(
                in_array($user->id, $ids->toArray())
            )
        );
    }

    public function testHashedKeysWithEnableHashedIdMode(): void
    {
        Config::set('apiato.hash-id', true);

        $users = UserModel::factory()
            ->count(3)
            ->create();

        $ids = $users->getHashedKeys();

        $this->assertInstanceOf(Collection::class, $ids);
        $this->assertCount($users->count(), $users);

        $ids
            ->each(
                fn($id) => $this->assertIsString($id)
            );
    }

    public function testHashedKeysCustom(): void
    {
        Config::set('apiato.hash-id', true);

        $organization = OrganizationModel::factory()->create();

        $users = UserModel::factory()
            ->count(3)
            ->create([
                User::ORGANIZATION_ID => $organization->id
            ]);

        $ids = $users->getHashedKeys(User::ORGANIZATION_ID);

        $this->assertInstanceOf(Collection::class, $ids);
        $this->assertCount($users->count(), $users);

        $ids
            ->each(
                fn($id) => $this->assertSame($organization->getHashedKey(), $id)
            );
    }
}
