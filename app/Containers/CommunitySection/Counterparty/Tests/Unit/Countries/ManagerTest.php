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

namespace App\Containers\CommunitySection\Counterparty\Tests\Unit\Countries;

use App\Containers\CommunitySection\Counterparty\Countries\Manager;
use App\Containers\CommunitySection\Counterparty\Countries\RusCountry;
use App\Containers\CommunitySection\Counterparty\Tests\UnitTestCase;

final class ManagerTest extends UnitTestCase
{
    public function testManager(): void
    {
        $manager = Manager::getInstance();
        $this->assertInstanceOf(RusCountry::class, $manager->get(RusCountry::class));
    }
}
