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
 *
 * @apiGroup Organization
 * @apiName registrationOrganization
 * @api {post} /v1/registration Зарегистрировать компанию
 * @apiDescription Зарегистрировать новую компанию.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiBody {String} [name] Название компании (Обязательное для `payment_type=ooo`).
 * @apiBody {String=ip,ooo,self_employed} ownership_type Тип собственности.
 * @apiBody {String} phone_number Контактный номер телефона.
 * @apiBody {String} owner_name Ф|И|О собственника.
 * @apiBody {String} password Пароль для входа.
 *
 * @apiUse OrganizationSuccessSingleResponse
 */

use App\Containers\CommunitySection\Organization\UI\API\Controllers\RegistrationOrganizationController;
use Illuminate\Support\Facades\Route;

Route::post('registration', RegistrationOrganizationController::class)
    ->name('api_community_organization_registration_organization');
