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
use App\Containers\OrganizationSection\OwnershipType\Manager;
use App\Containers\OrganizationSection\OwnershipType\OooType;

class OrgnipElement extends RuElement
{
    public const int DIGITS = 15;

    protected int $ordering = 8;
    protected string $type = Element::TYPE_INT;
    protected string $name = 'orgnip';

    protected array $rules = [
        'required',
        'numeric',
        'nullable',
        'digits:' . self::DIGITS
    ];

    public function getValidationMessages(): array
    {
        return [
            $this->validationRuleName('numeric') => $this->trans('rules.numeric'),
            $this->validationRuleName('digits') => $this->trans('rules.digits', [
                'digits' => self::DIGITS
            ])
        ];
    }

    public function forOwnershipTypes(): array
    {
        return [
            Manager::getInstance()
                ->get(OooType::class)
                ->getName()
        ];
    }
}
