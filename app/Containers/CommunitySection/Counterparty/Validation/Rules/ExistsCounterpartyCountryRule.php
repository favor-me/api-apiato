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

namespace App\Containers\CommunitySection\Counterparty\Validation\Rules;

use App\Containers\CommunitySection\Counterparty\Countries\Manager;
use App\Containers\CommunitySection\Counterparty\Facades\Container;
use App\Ship\Validation\ValidationRule;
use Closure;

class ExistsCounterpartyCountryRule extends ValidationRule
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->getManager()->has($value)) {
            $fail($this->message());
        }
    }

    public function message(): string
    {
        $countries = $this->getManager()
            ->all()
            ->keys()
            ->implode(', ');

        return Container::trans('container.validation.exists_country', [
            'countries' => $countries
        ]);
    }

    protected function getManager(): Manager
    {
        return Manager::getInstance();
    }
}
