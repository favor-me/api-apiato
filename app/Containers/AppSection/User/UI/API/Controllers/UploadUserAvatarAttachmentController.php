<?php

/**
 * YouBM application system.
 *
 * This file is part of the YouBM application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license YouBM license.
 * @copyright Copyright (C) YouBM.ru, All rights reserved.
 * @link https://youbm.ru
 */

namespace App\Containers\AppSection\User\UI\API\Controllers;

use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Foundation\UserFileUploader;
use App\Containers\AppSection\User\Services\UserAttachmentService;
use App\Containers\AppSection\User\UI\API\Requests\UploadUserAvatarAttachmentRequest;
use App\Ship\Parents\Controllers\ApiController;

class UploadUserAvatarAttachmentController extends ApiController
{
    public function __invoke(UploadUserAvatarAttachmentRequest $request)
    {
        $uploadService = new UserAttachmentService();

        $file = (new UserFileUploader())
            ->setUploadPath($uploadService->getUploadBasePath())
            ->setUploadedFileNewName('avatar')
            ->setModelId($uploadService->getModelId())
            ->setModelType($uploadService->getModelType())
            ->upload($request->file(User::AVATAR));

        dd($file);
    }
}
