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

use App\Containers\CommunitySection\Organization\Tasks\TrashOrganizationsTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Exceptions\DeleteResourceFailedException;

class TrashOrganizationsAction extends Action
{
    /**
     * @param array $ids
     * @return int
     * @throws DeleteResourceFailedException
     */
    public function run(array $ids): int
    {
        return app(TrashOrganizationsTask::class)->run($ids);
    }
}
