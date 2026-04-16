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

use App\Containers\OrganizationSection\UnitPrice\Foundation\UnitPrice;
use App\Containers\ShiftSection\Item\Foundation\Item;
use App\Containers\ShiftSection\ItemType\Validation\Rules\ExistsItemTypeRule;

return [

    'rules' => [
        Item::TYPE => [
            new ExistsItemTypeRule()
        ],
        Item::VALUE => [
            'numeric',
            'min:1',
            'max:' . UnitPrice::PRICE_MAX_LENGTH
        ],
        Item::DESCRIPTION => [
            'nullable',
            'string'
        ]
    ]

];
