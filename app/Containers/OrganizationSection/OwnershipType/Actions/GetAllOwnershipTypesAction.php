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

namespace App\Containers\OrganizationSection\OwnershipType\Actions;

use App\Containers\OrganizationSection\OwnershipType\Tasks\GetAllOwnershipTypesTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;

class GetAllOwnershipTypesAction extends Action
{
    public function run(): Collection
    {
        return app(GetAllOwnershipTypesTask::class)->run();
    }
}
