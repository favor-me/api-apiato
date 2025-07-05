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

namespace App\Containers\CommunitySection\OrganizationUnitType\Tests\Unit;

use App\Containers\CommunitySection\OrganizationUnitType\Facades\Container;
use App\Containers\CommunitySection\OrganizationUnitType\Manager;
use App\Containers\CommunitySection\OrganizationUnitType\ProductType;
use App\Containers\CommunitySection\OrganizationUnitType\Tests\UnitTestCase;

final class ManagerTest extends UnitTestCase
{
    public function testGet(): void
    {
        $product = Manager::getInstance()->get(ProductType::class);
        $this->assertSame('product', $product->getName());
        $this->assertSame(Container::trans('container.product.title'), $product->getTitle());
    }
}
