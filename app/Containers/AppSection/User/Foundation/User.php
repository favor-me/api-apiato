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

namespace App\Containers\AppSection\User\Foundation;

use App\Ship\Foundation\SectionContainer;

final class User extends SectionContainer
{
    public const ID = 'user_id';
    public const PARAM_ENABLE_RESERVATION_FORM = 'enable_reservation_form';
    public const PARAM_CURRENCY = 'currency';
    public const PHONE_NUMBER = 'phone_number';
    public const PHONE_NUMBER_VERIFIED_AT = 'phone_number_verified_at';
    public const PATRONYMIC = 'patronymic';
    public const SURNAME = 'surname';
    public const GENDER = 'gender';
    public const IS_ADMIN = 'is_admin';
    public const BIRTH = 'birth';
    public const AVATAR = 'avatar';
    public const PASSWORD = 'password';
    public const NAME = 'name';
    public const LOGIN = 'login';
    public const EMAIL = 'email';
    public const EMAIL_VERIFIED_AT = 'email_verified_at';
    public const REMEMBER_TOKEN = 'remember_token';
    public const ORGANIZATION_ID = 'organization_id';
    public const IS_ORGANIZATION_OWNER = 'is_organization_owner';
    public const NAME_MAX_LENGTH = 30;
    public const PHONE_NUMBER_MAX_LENGTH = 14;
    public const NAME_MIN_LENGTH = 2;
    public const SURNAME_MAX_LENGTH = 30;
    public const PATRONYMIC_MAX_LENGTH = 30;
    public const AVATAR_MAX_LENGTH = 50;
    public const EMAIL_MAX_LENGTH = 40;
    public const PASSWORD_MAX_LENGTH = 40;
    public const PASSWORD_MIN_LENGTH = 6;
    public const LOGIN_MAX_LENGTH = 50;

    protected string $apiBaseUri = 'users';
}
