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

namespace App\Containers\AppSection\User\UI\API\Requests;

use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Requests\UserApiRequest;
use App\Ship\Collections\ValidationRules;

class UploadUserAvatarAttachmentRequest extends UserApiRequest
{
    public function rules(): array
    {
        return [
            User::AVATAR => $this->getUserAvatarValidationRules()
        ];
    }

    public function getUserAvatarValidationRules(): ValidationRules
    {
        return parent::getUserAvatarValidationRules()->addRequired();
    }
}
