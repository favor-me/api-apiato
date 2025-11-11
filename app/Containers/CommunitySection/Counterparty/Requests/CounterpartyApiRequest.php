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

namespace App\Containers\CommunitySection\Counterparty\Requests;

use App\Containers\CommunitySection\Organization\Traits\OrganizationValidationRules;
use App\Containers\AppSection\User\Traits\IsOrganizationUser;
use App\Containers\CommunitySection\Counterparty\Foundation\Counterparty;
use App\Containers\CommunitySection\Counterparty\Traits\CounterpartyValidationRules;
use App\Containers\CommunitySection\Counterparty\UI\API\Transformers\AdminCounterpartyTransformer;
use App\Containers\CommunitySection\Counterparty\UI\API\Transformers\CounterpartyTransformer;
use App\Ship\Contracts\GettableTransformer;
use App\Ship\Parents\Transformers\Transformer;
use App\Ship\Requests\ApiRequest;

/**
 * @property-read mixed $organization_id
 */
abstract class CounterpartyApiRequest extends ApiRequest implements GettableTransformer
{
    use IsOrganizationUser;
    use OrganizationValidationRules;
    use CounterpartyValidationRules;

    protected array $decode = [
        Counterparty::ORGANIZATION_ID
    ];

    public function getTransformer(): Transformer
    {
        return $this->isAdminUser() ? new AdminCounterpartyTransformer() : new CounterpartyTransformer();
    }

    protected function prepareForValidation(): void
    {
        $this->prepareForValidationOrganizationId();
    }

    protected function prepareForValidationOrganizationId(): void
    {
        if (!is_null($this->user())) {
            $this->merge([
                Counterparty::ORGANIZATION_ID => $this->user()->getHashedKey(Counterparty::ORGANIZATION_ID)
            ]);
        }
    }

    protected function getCheckAuthorizeMethods(): array
    {
        return array_merge(parent::getCheckAuthorizeMethods(), [
            'isOrganizationUser'
        ]);
    }
}
