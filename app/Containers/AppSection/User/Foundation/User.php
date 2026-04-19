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

namespace App\Containers\AppSection\User\Foundation;

use App\Ship\Foundation\SectionContainer;

final class User extends SectionContainer
{
    public const string ID = 'user_id';
    public const string TELEGRAM_USER_NAME = 'telegram_user_name';
    public const string PARAM_ENABLE_RESERVATION_FORM = 'enable_reservation_form';
    public const string PARAM_CURRENCY = 'currency';
    public const string PHONE_NUMBER = 'phone_number';
    public const string PHONE_NUMBER_VERIFIED_AT = 'phone_number_verified_at';
    public const string PATRONYMIC = 'patronymic';
    public const string SURNAME = 'surname';
    public const string GENDER = 'gender';
    public const string IS_ADMIN = 'is_admin';
    public const string BIRTH = 'birth';
    public const string AVATAR = 'avatar';
    public const string PASSWORD = 'password';
    public const string NAME = 'name';
    public const string LOGIN = 'login';
    public const string EMAIL = 'email';
    public const string EMAIL_VERIFIED_AT = 'email_verified_at';
    public const string REMEMBER_TOKEN = 'remember_token';
    public const string NOW_SHIFT = 'nowShift';
    public const string SHIFT_PARAMS_SCHEMA = 'shift_params_schema';
    public const string SHIFT_PARAMS = 'shift_params';
    public const string SHIFT_PARAMS_FIX_RATE = 'fix_rate';
    public const string SHIFT_PARAMS_IS_REQUIRED = 'is_required';
    public const string SHIFT_PARAMS_PERCENT_FROM_ORDER_PROFIT = 'percent_from_order_profit';
    public const string ORGANIZATION_ID = 'organization_id';
    public const string ORGANIZATION_BRANCH_ID = 'organization_branch_id';
    public const string IS_ORGANIZATION_OWNER = 'is_organization_owner';
    public const int NAME_MAX_LENGTH = 30;
    public const int PHONE_NUMBER_MAX_LENGTH = 14;
    public const int NAME_MIN_LENGTH = 2;
    public const int SURNAME_MAX_LENGTH = 30;
    public const int PATRONYMIC_MAX_LENGTH = 30;
    public const int AVATAR_MAX_LENGTH = 50;
    public const int EMAIL_MAX_LENGTH = 40;
    public const int PASSWORD_MAX_LENGTH = 40;
    public const int PASSWORD_MIN_LENGTH = 6;
    public const int LOGIN_MAX_LENGTH = 50;

    protected string $apiBaseUri = 'users';
}
