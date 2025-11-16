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

namespace App\Containers\CommunitySection\Counterparty\Tests\Unit\Countries\BankData;

use App\Containers\CommunitySection\Counterparty\Countries\BankData\Collection;
use App\Containers\CommunitySection\Counterparty\Countries\BankData\Ru\InnElement;
use App\Containers\CommunitySection\Counterparty\Tests\UnitTestCase;

final class CollectionTest extends UnitTestCase
{
    public function testAdd(): void
    {
        $collection = new Collection();

        $result = $collection->add(new InnElement());

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertIsArray($collection->getElements());
        $this->assertCount(1, $collection->getElements());
    }
}
