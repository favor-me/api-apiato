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

namespace App\Containers\OrderSection\Item\Requests;

use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Traits\IsOrganizationUser;
use App\Containers\CommunitySection\OrganizationUnit\Traits\OrganizationUnitValidationRules;
use App\Containers\OrderSection\Item\Traits\ItemValidationRules;
use App\Containers\OrderSection\Item\UI\API\Transformers\ItemTransformerManager;
use App\Containers\OrderSection\Order\Foundation\Order;
use App\Containers\OrderSection\Order\Traits\OrderValidationRules;
use App\Ship\Contracts\GettableTransformer;
use App\Ship\Parents\Transformers\Transformer;
use App\Ship\Requests\ApiRequest;

abstract class ItemApiRequest extends ApiRequest implements GettableTransformer
{
    use IsOrganizationUser;
    use ItemValidationRules;
    use OrderValidationRules;
    use OrganizationUnitValidationRules;

    public function getTransformer(): Transformer
    {
        return (new ItemTransformerManager())->getDefaultOrAdmin();
    }

    protected function getCheckAuthorizeMethods(): array
    {
        return array_merge(parent::getCheckAuthorizeMethods(), [
            'isOrganizationUser'
        ]);
    }

    protected function prepareForValidation(): void
    {
        $this->prepareForValidationOrganizationId();
    }

    protected function prepareForValidationOrganizationId(): void
    {
        $this->merge([
            Order::ORGANIZATION_ID => $this->user()->getHashedKey(User::ORGANIZATION_ID)
        ]);
    }
}
