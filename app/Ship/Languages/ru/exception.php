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

use App\Ship\Middlewares\Http\TimeZone;

// @codingStandardsIgnoreStart

return [
    'empty_update_data' => 'Данные для обновления не найдены.',
    'failed_create_resource' => 'Не возможно создать ресурс ресурс.',
    'failed_delete_resource' => 'Не возможно удалить ресурс.',
    'gave_role_permission_info' => 'Предоставили роли «:role» следующие права: «:permission».',
    'given_data_was_invalid' => 'Указанные данные недействительны.',
    'inputs_empty' => 'Входные данные пусты',
    'invalid_system_date_format' => 'Неверный формат даты. Используйте dd.mm.yyyy',
    'invalid_week_day' => 'Не верно указан номер дня недели.',
    'no_found_resource' => 'Запрошенный ресурс не найден.',
    'no_resources_found_to_delete' => 'Не найдены ресурсы для удаления',
    'only_hashed_id_allowed' => 'Необходимо передавать только хэшированные данные. :field=:value',
    'repository_no_exists' => 'Нет доступного защищенного или общедоступного репозитория',
    'role_not_found' => 'Роль «:role» не найдена',
    'something_went_wrong' => 'Что то пошло не так.',
    'unable_to_remove_superuser' => 'Не возможно удалить супер-админа.',
    'unauthorized_action' => 'Это действие несанкционированно.',
    'update_data_empty' => 'Данные для обновления не обнаружены.',
    'missing_time_zone_header' => 'Ваш запрос должен содержать заголовок ' . TimeZone::HEADER . ' с корректным UTC значением.'
];
