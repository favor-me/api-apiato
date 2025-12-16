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

use App\Containers\CommunitySection\Counterparty\Actions\GetCounterpartyBankDataSchemaAction;
use App\Containers\CommunitySection\Counterparty\UI\API\Requests\GetCounterpartyBankDataSchemaRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use ReflectionException;

class GetCounterpartyBankDataSchemaController extends ApiController
{
    /**
     * @param GetCounterpartyBankDataSchemaRequest $request
     * @param GetCounterpartyBankDataSchemaAction $action
     * @return JsonResponse
     * @throws ReflectionException
     */
    public function __invoke(
        GetCounterpartyBankDataSchemaRequest $request,
        GetCounterpartyBankDataSchemaAction $action
    ): JsonResponse {
        return $this->json([
            'data' => $action->run(
                $request->country,
                $request->ownership_type,
                (bool)$request->get('test_data')
            )
        ]);
    }
}
