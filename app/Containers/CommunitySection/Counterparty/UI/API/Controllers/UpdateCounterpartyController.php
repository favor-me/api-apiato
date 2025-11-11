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

namespace App\Containers\CommunitySection\Counterparty\UI\API\Controllers;

use Apiato\Core\Facades\Response;
use App\Containers\CommunitySection\Counterparty\Actions\UpdateCounterpartyAction;
use App\Containers\CommunitySection\Counterparty\UI\API\Requests\UpdateCounterpartyRequest;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UpdateCounterpartyController extends ApiController
{
    /**
     * @param UpdateCounterpartyRequest $request
     * @param UpdateCounterpartyAction $action
     * @return JsonResponse
     * @throws UnknownProperties
     * @throws UpdateResourceFailedException
     */
    public function __invoke(
        UpdateCounterpartyRequest $request,
        UpdateCounterpartyAction $action
    ): JsonResponse {
        return Response::create(
            $action->run($request->getDto()),
            $request->getTransformer()
        )->ok();
    }
}
