<?php

/**
 * Beauty application system
 *
 * This file is part of the Beauty application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     Proprietary
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved.
 * @link        https://kalistratov.ru
 */

namespace App\Containers\AppSection\Authorization\Actions;

use App\Containers\AppSection\Authorization\Dto\CreatePermissionDto;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Containers\AppSection\Authorization\Models\Permission;
use App\Containers\AppSection\Authorization\Tasks\CreatePermissionTask;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CreatePermissionAction extends Action
{
    /**
     * @param Request $request
     * @return Permission
     * @throws CreateResourceFailedException
     * @throws UnknownProperties
     */
    public function run(Request $request): Permission
    {
        $dto = new CreatePermissionDto($request->all());
        return app(CreatePermissionTask::class)->run($dto);
    }
}
