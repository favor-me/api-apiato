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

namespace App\Containers\OrderSection\Order\Tests\Functional;

use App\Containers\OrderSection\Order\Tests\FunctionalTestCase;
use App\Containers\OrderSection\Status\Foundation\Status;
use App\Containers\OrderSection\Status\Models\Status as StatusModel;

abstract class ApiTestCase extends FunctionalTestCase
{
    public function getCompletedStatus(): StatusModel
    {
        return StatusModel::where(Status::SLUG, StatusModel::COMPLETED)->first();
    }
}
