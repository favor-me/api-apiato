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

namespace App\Containers\CommunitySection\Counterparty\Tests\Unit\Validation\Rules;

use App\Containers\CommunitySection\Counterparty\Countries\Manager;
use App\Containers\CommunitySection\Counterparty\Facades\Container;
use App\Containers\CommunitySection\Counterparty\Tests\UnitTestCase;
use App\Containers\CommunitySection\Counterparty\Validation\Rules\ExistsCounterpartyCountryRule;

final class ExistsCounterpartyCountryRuleTest extends UnitTestCase
{
    public function testValidation(): void
    {
        $rule = new ExistsCounterpartyCountryRule();

        $rule->validate('country', 'fail', function (string $message) {
            $this->assertSame($this->getExpectedMessage(), $message);
        });

        $rule->validate('country', 'lala', function (string $message) {
            $this->assertSame($this->getExpectedMessage(), $message);
        });
    }

    public function testMessage(): void
    {
        $rule = new ExistsCounterpartyCountryRule();
        $this->assertSame($this->getExpectedMessage(), $rule->message());
    }

    protected function getExpectedMessage(): string
    {
        $countries = Manager::getInstance()
            ->all()
            ->keys()
            ->implode(', ');

        return Container::trans('container.validation.exists_country', [
            'countries' => $countries
        ]);
    }
}
