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

use App\Containers\AccountingSection\Contract\Foundation\Contract;
use App\Ship\Parents\Transformers\Transformer;

return [

    'rules' => [
        Contract::NAME => [
            'string',
            'max:' . SCHEMA_DEFAULT_STRING_LENGTH
        ],
        Contract::START_AT => [
            'date_format:' . Transformer::HUMAN_DATE_FORMAT
        ],
        Contract::FINISH_AT => [
            'nullable',
            'date_format:' . Transformer::HUMAN_DATE_FORMAT
        ]
    ]

];
