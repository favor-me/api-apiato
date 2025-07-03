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

use App\Containers\CommunitySection\OrganizationBranch\Foundation\OrganizationBranch;

return [
    OrganizationBranch::NAME => [
        'required' => 'Укажите название отделения организации.'
    ],
    OrganizationBranch::PHONE_NUMBER => [
        'required' => 'Укажите контактный номер отделения организации.'
    ],
    OrganizationBranch::LOCATION => [
        'required' => 'Укажите расположение отделения организации.'
    ]
];
