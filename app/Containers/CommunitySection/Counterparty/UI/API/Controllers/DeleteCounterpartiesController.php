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

use App\Containers\CommunitySection\Counterparty\Actions\DeleteCounterpartiesAction;
use App\Containers\CommunitySection\Counterparty\Facades\Container;
use App\Containers\CommunitySection\Counterparty\UI\API\Requests\DeleteCounterpartiesRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class DeleteCounterpartiesController extends ApiController
{
    /**
     * @param DeleteCounterpartiesRequest $request
     * @param DeleteCounterpartiesAction $action
     * @return JsonResponse
     * @throws NotFoundException
     */
    public function __invoke(
        DeleteCounterpartiesRequest $request,
        DeleteCounterpartiesAction $action
    ): JsonResponse {
        $result = $action->run($request->getIds());
        return $this->json([
            MESSAGE => Container::transMultipleDeleted($result)
        ]);
    }
}
