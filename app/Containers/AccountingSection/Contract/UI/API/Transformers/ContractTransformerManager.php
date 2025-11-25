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

namespace App\Containers\AccountingSection\Contract\UI\API\Transformers;

use App\Ship\Transformers\TransformerManager;

class ContractTransformerManager extends TransformerManager
{
    public function getDefault(): ContractTransformer
    {
        return new ContractTransformer();
    }

    public function getAdmin(): AdminContractTransformer
    {
        return new AdminContractTransformer();
    }

    public function getToList(): ?ContractToListTransformer
    {
        return new ContractToListTransformer();
    }
}
