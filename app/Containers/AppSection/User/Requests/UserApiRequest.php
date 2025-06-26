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

namespace App\Containers\AppSection\User\Requests;

use App\Containers\AppSection\Profile\Traits\HasProfileValidationRules;
use App\Containers\AppSection\User\Traits\HasUserValidationRules;
use App\Containers\AppSection\User\UI\API\Transformers\UserTransformer;
use App\Ship\Contracts\GettableTransformer;
use App\Ship\Parents\Transformers\Transformer;
use App\Ship\Requests\ApiRequest;
use App\Ship\Utils\Str;
use AppSection\User\UI\API\Transformers\AdminUserTransformer;

abstract class UserApiRequest extends ApiRequest implements GettableTransformer
{
    use HasUserValidationRules;
    use HasProfileValidationRules;

    protected array $stripTagsFields = [
        'about_me'
    ];

    public function messages(): array
    {
        return [
            'name.min' => __('appSection@user::validation.name.min'),
            'login.unique' => __('appSection@user::validation.login.unique'),
            'surname.min' => __('appSection@user::validation.surname.min'),
            'token.required' => __('appSection@user::validation.token.required'),
            'patronymic.min' => __('appSection@user::validation.patronymic.min')
        ];
    }

    public function getTransformer(): Transformer
    {
        return $this->isAdminUser() ? new AdminUserTransformer() : new UserTransformer();
    }

    protected function createProfileData(): void
    {
        $profileData = [];
        $profileFields = array_keys($this->getUserProfileRules());

        foreach ($profileFields as $profileField) {
            if ($this->has($profileField)) {
                $profileData[$profileField] = $this->$profileField;
                $this->offsetUnset($profileField);
            }
        }

        $this->merge([
            'profile' => $profileData
        ]);
    }

    protected function getUserProfileRules(): array
    {
        return [
            'about_me' => $this->getUserProfileAboutMeRules(),
            'address' => $this->getUserProfileAddressRules(),
            'latitude' => $this->getUserProfileLatitudeRules(),
            'longitude' => $this->getUserProfileLongitudeRules()
        ];
    }

    protected function getUserRules(): array
    {
        return [
            'name' => $this->getUserNameValidationRules(),
            'email' => $this->getUserEmailValidationRules(),
            'birth' => $this->getUserBirthValidationRules(),
            'login' => $this->getUserLoginValidationRules(),
            'gender' => $this->getUserGenderValidationRules(),
            'surname' => $this->getUserSurnameValidationRules(),
            'password' => $this->getUserPasswordValidationRules(),
            'patronymic' => $this->getUserPatronymicValidationRules(),
            'phone_number' => $this->getUserPhoneNumberValidationRules(),
            'role' => $this->getUserRegistrationRolesValidationRules()
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->stripTagsInDataFields();
        $this->clearPhoneNumber();
    }

    protected function clearPhoneNumber(): void
    {
        if ($this->has('phone_number')) {
            $this->merge([
                'phone_number' => Str::toPhoneNumber($this->get('phone_number'))
            ]);
        }
    }

    protected function stripTagsInDataFields(): void
    {
        foreach ($this->stripTagsFields as $stripTagsField) {
            if ($this->has($stripTagsField)) {
                $this->merge([
                    $stripTagsField => strip_tags($this->get($stripTagsField))
                ]);
            }
        }
    }

    protected function passedValidation(): void
    {
        $this->createProfileData();
    }
}
