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

use App\Containers\AppSection\User\Models\User;
use App\Ship\Database\Eloquent\Collection;
use App\Ship\Tests\UnitTestCase;
use Illuminate\Support\Facades\Config;

class CollectionTest extends UnitTestCase
{
    public function testGetIdsWithDisableHashedIdMode(): void
    {
        Config::set('apiato.hash-id', false);

        $users = User::factory()
            ->count(5)
            ->create();

        $this->assertInstanceOf(Collection::class, $users);

        $ids = $users->getIds();
        $this->assertIsArray($ids);
        $this->assertSame($users->count(), count($ids));

        $users->each(fn(User $user) => $this->assertTrue(in_array($user->id, $ids)));
    }

    public function testGetIdsWithEnableHashedIdMode(): void
    {
        Config::set('apiato.hash-id', true);

        $count = 10;
        $users = User::factory()->count($count)->create();

        $this->assertInstanceOf(Collection::class, $users);

        $ids = $users->getIds();
        $this->assertIsArray($ids);
        $this->assertSame($count, count($ids));

        foreach ($ids as $id) {
            $this->assertIsString($id);
        }
    }
}
