<?php

/**
 * ERP system
 *
 * This file is part of the ERM system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    Proprietary
 * @copyright  Copyright (C) zemlechist.ru, All rights reserved.
 * @link       https://zemlechist.ru
 */

namespace App\Containers\HistorySection\ModelNote\Tests\Unit\Tasks;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\User\Models\User;
use App\Containers\HistorySection\ModelNote\Models\ModelNote;
use App\Containers\HistorySection\ModelNote\Tasks\GetAllModelNotesTask;
use App\Containers\HistorySection\ModelNote\Tests\TestCase;

final class GetAllModelNotesTaskTest extends TestCase
{
    public function testAll(): void
    {
        $totalTestModelNotes = $this->createTestModelNotes();

        $result = app(GetAllModelNotesTask::class)->run();

        $this->assertCount($totalTestModelNotes, $result);
    }

    public function testAllForModel(): void
    {
        $this->createTestModelNotes();

        $result = app(GetAllModelNotesTask::class)
            ->forModel(User::class)
            ->run();

        $this->assertCount(1, $result);
        $this->assertSame(User::class, $result->first()->model);
    }

    protected function createTestModelNotes(): int
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();

        ModelNote::factory()
            ->model($user)
            ->typeSystemMessage()
            ->create();

        ModelNote::factory()
            ->model($role)
            ->typeSystemMessage()
            ->create();

        return 2;
    }
}
