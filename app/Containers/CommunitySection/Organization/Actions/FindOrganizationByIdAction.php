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

namespace App\Containers\CommunitySection\Organization\Actions;

use App\Containers\CommunitySection\Organization\Models\Organization;
use App\Containers\CommunitySection\Organization\Tasks\FindOrganizationByIdTask;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action;

class FindOrganizationByIdAction extends Action
{
    /**
     * @param int $id
     * @return Organization
     * @throws NotFoundException
     */
    public function run(int $id): Organization
    {
        return app(FindOrganizationByIdTask::class)->run($id);
    }
}
