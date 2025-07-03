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
 *
 * @apiGroup Organization
 * @apiName registrationOrganization
 * @api {post} /v1/registration Зарегистрировать компанию
 * @apiDescription Зарегистрировать новую компанию.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь
 *
 * @apiBody {String} name Название компании.
 * @apiBody {String} phone_number Контактный номер телефона.
 * @apiBody {String} owner_name Ф|И|О собственника.
 * @apiBody {String} password Пароль для входа.
 * @apiBody {String} [inn] ИНН.
 * @apiBody {String} [email] Контактный адрес электронной почты.
 *
 * @apiUse OrganizationSuccessSingleResponse
 */

use App\Containers\CommunitySection\Organization\UI\API\Controllers\RegistrationOrganizationController;
use Illuminate\Support\Facades\Route;

Route::post('registration', RegistrationOrganizationController::class)
    ->name('api_community_organization_registration_organization');
