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

use App\Containers\CommunitySection\Counterparty\Actions\RestoreCounterpartiesAction;
use App\Containers\CommunitySection\Counterparty\Facades\Container;
use App\Containers\CommunitySection\Counterparty\UI\API\Requests\RestoreCounterpartiesRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class RestoreCounterpartiesController extends ApiController
{
    /**
     * @param RestoreCounterpartiesRequest $request
     * @param RestoreCounterpartiesAction $action
     * @return JsonResponse
     * @throws NotFoundException
     */
    public function __invoke(
        RestoreCounterpartiesRequest $request,
        RestoreCounterpartiesAction $action
    ): JsonResponse {
        $result = $action->run($request->getIds());

        return $this->accepted([
            MESSAGE => Container::transMultipleRestored($result)
        ]);
    }
}
