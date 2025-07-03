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

namespace App\Containers\CommunitySection\OrganizationBranch\UI\API\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\CommunitySection\OrganizationBranch\Actions\UpdateOrganizationBranchAction;
use App\Containers\CommunitySection\OrganizationBranch\UI\API\Requests\UpdateOrganizationBranchRequest;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UpdateOrganizationBranchController extends ApiController
{
    /**
     * @param UpdateOrganizationBranchRequest $request
     * @param UpdateOrganizationBranchAction $action
     * @return JsonResponse
     * @throws InvalidTransformerException
     * @throws UnknownProperties
     * @throws UpdateResourceFailedException
     */
    public function __invoke(UpdateOrganizationBranchRequest $request, UpdateOrganizationBranchAction $action): JsonResponse
    {
        return $this->json(
            $this->transform(
                $action->run($request->getDto()),
                $request->getTransformer()
            )
        );
    }
}
