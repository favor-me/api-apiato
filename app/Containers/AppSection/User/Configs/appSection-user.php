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

use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Ship\Validation\Rules\PhoneNumber;

return [

    /*
    |--------------------------------------------------------------------------
    | Reset Password
    |--------------------------------------------------------------------------
    |
    | Insert your allowed reset password urls to inject into the email.
    |
    */
    'allowed-reset-password-urls' => [
        'password-reset'
    ],

    'registration' => [
        'allowed-roles' => [
            Role::ORGANIZATION_OWNER
        ],
        'default-role' => Role::ORGANIZATION_OWNER
    ],


    /*
    |--------------------------------------------------------------------------
    | This email for create super admin user.
    |--------------------------------------------------------------------------
    |
    | Use in:
    | 1. App\Containers\AppSection\User\Tasks\DeleteUserTask (Unable to remove super user)
    | 2. App\Containers\AppSection\Authorization\Data\Seeders\AuthorizationDefaultUsersSeeder_3 (Create super user)
    |
    */
    'super-admin-email' => 'sergey@kalistratov.ru',

    'rules' => [
        ID => [
            'exists:' . UserModel::TABLE . ',' . ID
        ],
        User::LOGIN => [
            'max:' . User::LOGIN_MAX_LENGTH,
            'unique:' . UserModel::TABLE . ',' . User::LOGIN
        ],
        User::NAME => [
            'min:' . User::NAME_MIN_LENGTH,
            'max:' . User::NAME_MAX_LENGTH
        ],
        User::SURNAME => [
            'nullable',
            'min:' . User::NAME_MIN_LENGTH,
            'max:' . User::NAME_MAX_LENGTH
        ],
        User::PATRONYMIC => [
            'nullable',
            'min:' . User::NAME_MIN_LENGTH,
            'max:' . User::PASSWORD_MAX_LENGTH
        ],
        User::GENDER => [
            'nullable',
            'boolean'
        ],
        User::BIRTH => [
            'nullable',
            'date'
        ],
        User::AVATAR => [
            'image',
            'max:' . env('ATTACHMENT_IMAGE_MAX_SIZE', 1) * 1024,
            'mimes:' . env('ATTACHMENT_IMAGE_EXT', 'jpg,jpeg,png')
        ],
        User::EMAIL => [
            'nullable',
            'email',
            'max:' . User::EMAIL_MAX_LENGTH
        ],
        User::PHONE_NUMBER => [
            'nullable',
            'unique:' . UserModel::TABLE . ',' . User::PHONE_NUMBER,
            new PhoneNumber()
        ],
        User::PASSWORD => [
            'min:' . User::PASSWORD_MIN_LENGTH,
            'max:' . User::PASSWORD_MAX_LENGTH
        ]
    ]

];
