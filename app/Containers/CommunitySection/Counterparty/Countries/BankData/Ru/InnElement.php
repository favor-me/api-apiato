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
use App\Containers\CommunitySection\Counterparty\Models\Counterparty;
use App\Containers\CommunitySection\Counterparty\Validation\Rules\UniqueCounterpartyRule;
use App\Containers\CommunitySection\Organization\Validation\Rules\UniqueOrganizationRule;
use JBZoo\Data\JSON;

class InnElement extends RuElement
{
    public const int MAX_DIGITS = 12;
    public const int MIN_DIGITS = 10;

    protected int $ordering = 10;
    protected string $type = Element::TYPE_INT;
    protected string $name = 'inn';

    protected array $rules = [
        'required',
        'numeric',
        'min_digits:' . self::MIN_DIGITS,
        'max_digits:' . self::MAX_DIGITS
    ];

    public function __construct(JSON $data = null, ?string $ownershipType = null)
    {
        parent::__construct($data, $ownershipType);
        $this->rules[] = $this->getUniqValidationRule();
    }

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

    public function getUniqValidationRule(): UniqueOrganizationRule
    {
        $ignoreValue = $this->country->getIgnoreValue();

        if ($this->country->getContext() === Counterparty::class) {
            return new UniqueCounterpartyRule($ignoreValue);
        }

        return new UniqueOrganizationRule($ignoreValue);
    }
}
