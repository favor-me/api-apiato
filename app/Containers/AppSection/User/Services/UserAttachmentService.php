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

namespace App\Containers\AppSection\User\Services;

use App\Containers\AppSection\User\Models\User as UserModel;
use App\Ship\Utils\Str;
use Illuminate\Support\Facades\Auth;

class UserAttachmentService
{
    protected UserModel $user;

    public function __construct(mixed $user = null)
    {
        if (is_null($user)) {
            $this->user = Auth::user();
        } elseif ($user instanceof UserModel) {
            $this->user = $user;
        }
    }

    public function getModelId(): int
    {
        return $this->user->id;
    }

    public function getModelType(): string
    {
        return $this->user::class;
    }

    public function getUploadBasePath(): string
    {
        return Str::toPath($this->user->id) . '/u' . $this->user->id;
    }
}
