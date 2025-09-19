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

namespace App\Containers\OrderSection\Order\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\OrderSection\Order\Requests\OrderApiRequest;
use App\Ship\Traits\Request\HasInputIds;
use Illuminate\Validation\Rules\Exists;

class RestoreOrdersRequest extends OrderApiRequest
{
    use HasInputIds;

    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER
        ]
    ];

    protected function afterInitialize(): void
    {
        parent::afterInitialize();
        $this->mergeDecode(IDS . '.*');
    }

    public function rules(): array
    {
        return [
            IDS . '.*' => $this->getOrderIdValidationRules()
        ];
    }

    public function getOrderIdExistsValidationRule(string $column = 'NULL'): Exists
    {
        return parent::getOrderIdExistsValidationRule($column)
            ->whereNotNull(DELETED_AT);
    }
}
