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

namespace App\Containers\OrganizationSection\UnitPrice\Tasks;

use App\Containers\OrganizationSection\UnitPrice\Data\Repositories\UnitPriceRepository;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Traits\Task\OnlyTrashed;

abstract class UnitPriceTask extends Task
{
    use OnlyTrashed;

    public function __construct(
        protected UnitPriceRepository $repository
    ) {
    }
}
