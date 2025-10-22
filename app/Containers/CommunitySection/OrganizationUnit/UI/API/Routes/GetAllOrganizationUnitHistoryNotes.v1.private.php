<?php

/**
 * __PROJECT_NAME__
 *
 * This file is part of the __PROJECT_NAME__ package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license __PROJECT_LICENCE__
 * @copyright Copyright (C) __PROJECT_AUTHOR__, All rights reserved ©.
 * @link __PROJECT_URL__
 * @author __PROJECT_AUTHOR__ <__PROJECT_AUTHOR__EMAIL__>
 *
 * @apiGroup CommunityOrganizationUnit
 * @apiName getAllCommunityOrganizationUnitHistoryNotes
 * @api {get} /v1/community/organization-units/:id/history-notes История
 * @apiDescription История.
 *
 * @apiVersion 1.0.0
 * @apiPermission Аутентифицированный пользователь с ролями `organization_owner`, `organization_worker`
 *
 * @apiParam {String} id Уникальный идентификатор.
 *
 * @apiSuccessExample {json} Успешный ответ:
HTTP/1.1 200 OK
{
    "data": [
        {
            "object": "ModelNote",
            "id": "n8WpRVOp9yGolAaw",
            "type": {
                "name": "system_message",
                "title": "Системное сообщенине"
            },
            "model": "App\\Containers\\CommunitySection\\OrganizationUnit\\Models\\OrganizationUnit",
            "model_id": "P2n5peyBD0oQkqLl",
            "event_id": "lG7or2NMwO3ZxRD1",
            "params": {
                "message": "Обновлено значение баланса. Предыдущее значение «0», новое значение «10».",
                "message_args": {
                    "old_value": 0,
                    "new_value": 10
                }
            },
            "created_by": "Q9V2RLOKZ0wEm1qY",
            "created_at": {
                "timestamp": 1760991457,
                "diff_for_humans": "1 день назад",
                "date_for_human": "2025-10-20",
                "date_for_human_full": "20 октября 2025г.",
                "date_for_human_full_with_time": "20 октября 2025г. в 23:17:37",
                "iso": "2025-10-20T23:17:37.000000+03:00",
                "time": "23:17:37",
                "timezone": "Europe/Moscow",
                "timezone_type": 3,
                "time_short": "23:17",
                "is_future": false
            },
            "event": {
                "data": {
                    "object": "ModelEvent",
                    "id": "lG7or2NMwO3ZxRD1",
                    "type": "plus_organization_unit_balance",
                    "model": "App\\Containers\\CommunitySection\\OrganizationUnit\\Models\\OrganizationUnit",
                    "model_id": "P2n5peyBD0oQkqLl",
                    "data": {
                        "balance": 0
                    },
                    "data_changes": {
                        "balance": 10
                    },
                    "created_at": 1760991457,
                    "updated_at": 1760991457
                }
            }
        },
    ]
}
 */

use App\Containers\CommunitySection\OrganizationUnit\Facades\Container;
use App\Containers\CommunitySection\OrganizationUnit\UI\API\Controllers\GetAllOrganizationUnitHistoryNotesController;
use Illuminate\Support\Facades\Route;

Route::get(Container::getApiUri('{' . ID . '}/history-notes'), GetAllOrganizationUnitHistoryNotesController::class)
    ->name('api_community_organization_unit_get_all_organization_unit_hostory_notes')
    ->middleware(['auth:api']);
