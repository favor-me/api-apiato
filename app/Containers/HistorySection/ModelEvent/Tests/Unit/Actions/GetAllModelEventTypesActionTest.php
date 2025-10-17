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

namespace App\Containers\HistorySection\ModelEvent\Tests\Unit\Actions;

use App\Containers\HistorySection\ModelEvent\Actions\GetAllModelEventTypesAction;
use App\Containers\HistorySection\ModelEvent\Tests\UnitTestCase;
use Illuminate\Support\Collection;

final class GetAllModelEventTypesActionTest extends UnitTestCase
{
    public function testAll(): void
    {
        $result = app(GetAllModelEventTypesAction::class)->run();
        $this->assertInstanceOf(Collection::class, $result);
    }
}
