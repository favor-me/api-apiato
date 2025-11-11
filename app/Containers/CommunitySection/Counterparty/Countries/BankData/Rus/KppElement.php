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

namespace App\Containers\CommunitySection\Counterparty\Countries\BankData\Rus;

use App\Containers\CommunitySection\Counterparty\Countries\BankData\Element;

class KppElement extends Element
{
    public const int DIGITS = 9;

    protected string $type = Element::TYPE_INT;
    protected string $name = 'kpp';

    protected array $rules = [
        'required',
        'numeric',
        'digits:' . self::DIGITS
    ];

    public function getValidationMessages(): array
    {
        return [
            $this->validationRuleName('required') => $this->trans('rules.required'),
            $this->validationRuleName('numeric') => $this->trans('rules.numeric'),
            $this->validationRuleName('digits') => $this->trans('rules.digits', [
                'digits' => self::DIGITS
            ])
        ];
    }
}
