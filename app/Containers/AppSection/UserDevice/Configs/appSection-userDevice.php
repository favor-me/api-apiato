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

use App\Containers\AppSection\UserDevice\Models\UserDevice;
use App\Containers\AppSection\UserDevice\Foundation\UserDevice as BaseUserDevice;

return [
    'rules' => [
        ID => [
            'exists:' . UserDevice::TABLE . ',' . ID
        ],
        BaseUserDevice::TOKEN => [
            'string',
            'max:' . SCHEMA_DEFAULT_STRING_LENGTH
        ],
        BaseUserDevice::MODEL => [
            'string',
            'max:' . BaseUserDevice::MODEL_MAX_LENGTH
        ]
    ]
];
