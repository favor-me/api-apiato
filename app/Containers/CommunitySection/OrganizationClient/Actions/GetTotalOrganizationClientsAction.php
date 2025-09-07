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

namespace App\Containers\CommunitySection\OrganizationClient\Actions;

use App\Containers\CommunitySection\OrganizationClient\Tasks\GetTotalOrganizationClientsTask;
use App\Ship\Parents\Actions\Action;

class GetTotalOrganizationClientsAction extends Action
{
    public function run(): int
    {
        return app(GetTotalOrganizationClientsTask::class)->run();
    }
}
