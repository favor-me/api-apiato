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

namespace App\Containers\AppSection\UserDevice\UI\API\Requests;

use App\Containers\AppSection\Authentication\Tasks\GetAuthenticatedUserTask;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Traits\IsOwnerTrait;
use App\Containers\AppSection\UserDevice\Dto\CreateUserDeviceDto;
use App\Containers\AppSection\UserDevice\Requests\UserDeviceApiRequest;
use App\Containers\AppSection\User\Foundation\User as BaseUser;
use App\Containers\AppSection\UserDevice\Foundation\UserDevice as BaseUserDevice;
use App\Ship\Collections\ValidationRules;
use App\Ship\Contracts\GettableDto;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

/**
 * @property-read mixed $user_id
 */
class CreateOrTouchUserDeviceRequest extends UserDeviceApiRequest implements GettableDto
{
    public function authorize(): bool
    {
        return $this->check([
            'hasAccess',
            'isOwner'
        ]);
    }

    public function isOwner(): bool
    {
        /** @var User $user */
        $user = app(GetAuthenticatedUserTask::class)->run();
        return $user->id === $this->user_id;
    }

    public function rules(): array
    {
        return [
            BaseUser::ID => $this->getUserIdValidationRules(),
            BaseUserDevice::MODEL => $this->getUserDeviceModelValidationRules(),
            BaseUserDevice::TOKEN => $this->getUserDeviceTokenValidationRules(),
        ];
    }

    public function getUserDeviceTokenValidationRules(): ValidationRules
    {
        return parent::getUserDeviceTokenValidationRules()->addRequired();
    }

    public function getUserDeviceModelValidationRules(): ValidationRules
    {
        return parent::getUserDeviceModelValidationRules()->addRequired();
    }

    public function getUserDeviceIdValidationRules(): ValidationRules
    {
        return parent::getUserIdValidationRules()->addRequired();
    }

    /**
     * @return CreateUserDeviceDto
     * @throws UnknownProperties
     */
    public function getDto(): CreateUserDeviceDto
    {
        return $this->newDto($this->validated());
    }

    /**
     * @param array $data
     * @return CreateUserDeviceDto
     * @throws UnknownProperties
     */
    public function newDto(array $data = []): CreateUserDeviceDto
    {
        return new CreateUserDeviceDto($data);
    }
}
