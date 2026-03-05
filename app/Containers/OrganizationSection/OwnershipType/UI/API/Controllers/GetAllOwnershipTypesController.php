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

namespace App\Containers\OrganizationSection\OwnershipType\UI\API\Controllers;

use Apiato\Core\Facades\Response;
use App\Containers\OrganizationSection\OwnershipType\Actions\GetAllOwnershipTypesAction;
use App\Containers\OrganizationSection\OwnershipType\UI\API\Requests\GetAllOwnershipTypesRequest;
use App\Containers\Vendor\Unit\UI\API\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * @SuppressWarnings(PHPMD.LongClassName)
 */
class GetAllOwnershipTypesController extends Controller
{
    public function __invoke(
        GetAllOwnershipTypesRequest $request,
        GetAllOwnershipTypesAction $action
    ): JsonResponse {
        return Response::create(
            $action->run(),
            $request->getTransformer()
        )->ok();
    }
}
