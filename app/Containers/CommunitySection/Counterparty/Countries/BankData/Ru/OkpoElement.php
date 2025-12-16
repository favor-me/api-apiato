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

class OkpoElement extends RuElement
{
    public const int MAX_DIGITS = 10;
    public const int MIN_DIGITS = 8;

    protected string $type = Element::TYPE_INT;
    protected string $name = 'okpo';
    protected int $ordering = 3;

    protected array $rules = [
        'required',
        'numeric',
        'min_digits:' . self::MIN_DIGITS,
        'max_digits:' . self::MAX_DIGITS
    ];

    public function getValidationMessages(): array
    {
        return [
            $this->validationRuleName('required') => $this->trans('rules.required'),
            $this->validationRuleName('numeric') => $this->trans('rules.numeric'),
            $this->validationRuleName('min_digits') => $this->trans('rules.min_digits', [
                'digits' => self::MIN_DIGITS
            ]),
            $this->validationRuleName('max_digits') => $this->trans('rules.max_digits', [
                'digits' => self::MAX_DIGITS
            ])
        ];
    }
}
