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

namespace App\Containers\AppSection\User\UI\API\Requests;

use App\Containers\AppSection\User\Dto\ResetUserPasswordDto;
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\AppSection\User\Requests\UserApiRequest;
use App\Ship\Collections\ValidationRules;
use App\Ship\Contracts\GettableDto;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ResetPasswordRequest extends UserApiRequest implements GettableDto
{
    public function getUserPasswordRules(): ValidationRules
    {
        return parent::getUserPasswordValidationRules()
            ->addRequired();
    }

    public function getUserTokenRules(): ValidationRules
    {
        return validation_rules([
            'required',
            'max:' . SCHEMA_DEFAULT_STRING_LENGTH
        ]);
    }

    public function getColumnNameValueValidationRules(): ValidationRules
    {
        return $this->getUserPhoneNumberValidationRules()
            ->removeUnique()
            ->addRequired();
    }

    public function rules(): array
    {
        return [
            'token' => $this->getUserTokenRules(),
            User::PASSWORD => $this->getUserPasswordRules(),
            $this->getColumnNameForPasswordReset() => $this->getColumnNameValueValidationRules()
        ];
    }

    /**
     * @return ResetUserPasswordDto
     * @throws UnknownProperties
     */
    public function getDto(): ResetUserPasswordDto
    {
        $validated = $this->validated();

        $data = array_merge($validated, [
            'value' => $validated[$this->getColumnNameForPasswordReset()]
        ]);

        return $this->newDto($data);
    }

    /**
     * @param array $data
     * @return ResetUserPasswordDto
     * @throws UnknownProperties
     */
    public function newDto(array $data = []): ResetUserPasswordDto
    {
        return new ResetUserPasswordDto($data);
    }

    protected function getColumnNameForPasswordReset(): string
    {
        return (new UserModel())->getColumnNameForPasswordReset();
    }
}
