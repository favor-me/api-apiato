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

namespace App\Containers\AppSection\UserDevice\UI\API\Controllers;

use App\Containers\AppSection\UserDevice\Actions\CreateOrTouchUserDeviceAction;
use App\Containers\AppSection\UserDevice\UI\API\Requests\CreateOrTouchUserDeviceRequest;
use App\Ship\Parents\Controllers\ApiController;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

final class Controller extends ApiController
{
    /**
     * @param CreateOrTouchUserDeviceRequest $request
     * @return JsonResponse
     * @throws CreateResourceFailedException
     * @throws InvalidTransformerException
     * @throws NotFoundException
     * @throws UnknownProperties
     * @throws UpdateResourceFailedException
     */
    public function createOrTouchUserDevice(CreateOrTouchUserDeviceRequest $request): JsonResponse
    {
        $userDevice = app(CreateOrTouchUserDeviceAction::class)->run($request->getDto());
        return $this->json($this->transform($userDevice, $request->getTransformer()));
    }
}
