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

namespace App\Containers\OrganizationSection\UnitPrice\Map;

use App\Containers\AccountingSection\Contract\Models\Contract as ContractModel;
use App\Containers\OrganizationSection\UnitPrice\Facades\Container;

class ContractType extends Type
{
    public function getModelAccessor(): string
    {
        return ContractModel::class;
    }

    public function getModelKey(): string
    {
        return 'contract';
    }

    public function getName(): string
    {
        return trans_choice(Container::transFullKey('container.items'), 1);
    }
}
