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

namespace App\Containers\CommunitySection\Counterparty\Countries\BankData\Ru;

use App\Containers\CommunitySection\Counterparty\Countries\BankData\Element;

class OkvedElement extends RuElement
{
    public const int MAX_LENGTH = 50;

    protected string $type = Element::TYPE_STRING;
    protected string $name = 'okved';
    protected int $ordering = 2;

    protected array $rules = [
        'string',
        'nullable',
        'max:' . self::MAX_LENGTH
    ];

    public function getValidationMessages(): array
    {
        return [
            $this->validationRuleName('required') => $this->trans('rules.required'),
            $this->validationRuleName('digits') => $this->trans('rules.max', [
                'max' => self::MAX_LENGTH
            ])
        ];
    }
}
