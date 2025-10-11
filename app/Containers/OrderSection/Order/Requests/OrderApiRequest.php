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

namespace App\Containers\OrderSection\Order\Requests;

use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Traits\IsOrganizationUser;
use App\Containers\CommunitySection\Organization\Traits\OrganizationValidationRules;
use App\Containers\CommunitySection\OrganizationClient\Traits\OrganizationClientValidationRules;
use App\Containers\CommunitySection\OrganizationUnit\Traits\OrganizationUnitValidationRules;
use App\Containers\OrderSection\Item\Traits\ItemValidationRules;
use App\Containers\OrderSection\Order\Facades\Container;
use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Traits\OrderValidationRules;
use App\Containers\OrderSection\Order\UI\API\Transformers\AdminOrderTransformer;
use App\Containers\OrderSection\Order\UI\API\Transformers\OrderTransformer;
use App\Containers\OrderSection\Status\Traits\StatusValidationRules;
use App\Ship\Contracts\GettableTransformer;
use App\Ship\Parents\Transformers\Transformer;
use App\Ship\Requests\ApiRequest;

/**
 * @property-read mixed $organization_id
 */
abstract class OrderApiRequest extends ApiRequest implements GettableTransformer
{
    use IsOrganizationUser;
    use ItemValidationRules;
    use OrderValidationRules;
    use OrganizationValidationRules;
    use OrganizationUnitValidationRules;
    use OrganizationClientValidationRules;
    use StatusValidationRules;

    protected array $decode = [
        Order::ORGANIZATION_ID
    ];

    public function messages(): array
    {
        return [
            Order::CLIENT_ID . '.exists' => Container::trans('validation.client_id.exists'),
            Order::PAYMENT_TYPE . '.required' => Container::trans('validation.payment_type.required')
        ];
    }

    public function getTransformer(): Transformer
    {
        return $this->isAdminUser() ? new AdminOrderTransformer() : new OrderTransformer();
    }

    protected function prepareForValidation()
    {
        $this->prepareForValidationOrganizationId();
    }

    protected function getCheckAuthorizeMethods(): array
    {
        return array_merge(parent::getCheckAuthorizeMethods(), [
            'isOrganizationUser'
        ]);
    }

    protected function prepareForValidationOrganizationId(): void
    {
        if (!is_null($this->user())) {
            $this->merge([
                Order::ORGANIZATION_ID => $this->user()->getHashedKey(User::ORGANIZATION_ID)
            ]);
        }
    }
}
