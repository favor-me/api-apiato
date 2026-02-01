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

return [
    'hello' => implode("\n", [
        'Добро пожаловать в FavorMe BOT.',
        'На данный момент я могу помочь вам восстановить пароль (воспользуйтесь командой /).'
    ]),
    'remember_pwd' => 'Для продолжения восстановления пароля подтвердите свои данные.',
    'send_contact' => 'Отправить контакт',
    'invalid_client_phone_number' => implode("\n", [
        'Мы не получили от вас контакт или вы указали не верный номер телефона. Пожалуйста попробуйте ещё раз.'
    ]),
    'reset_password_url' => implode("\n", [
        'Для восстановления пароля пройдите по <a href=":url">ссылке</a>'
    ])
];
