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
use App\Containers\CommunitySection\OrganizationBranch\Actions\CreateOrganizationBranchAction;
use App\Containers\CommunitySection\OrganizationBranch\UI\API\Requests\CreateOrganizationBranchRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CreateOrganizationBranchController extends ApiController
{
    /**
     * @param CreateOrganizationBranchRequest $request
     * @param CreateOrganizationBranchAction $action
     * @return JsonResponse
     * @throws CreateResourceFailedException
     * @throws InvalidTransformerException
     * @throws UnknownProperties
     */
    public function __invoke(CreateOrganizationBranchRequest $request, CreateOrganizationBranchAction $action): JsonResponse
    {
        $model = $action->run($request->getDto());
        return $this->created(
            $this->transform(
                $model,
                $request->getTransformer()
            )
        );
    }
}
