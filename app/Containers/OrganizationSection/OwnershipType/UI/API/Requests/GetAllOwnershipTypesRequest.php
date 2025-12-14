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

namespace App\Containers\OrganizationSection\OwnershipType\UI\API\Requests;

use App\Containers\OrganizationSection\OwnershipType\UI\API\Transformers\OwnershipTypeTransformer;
use App\Ship\Contracts\GettableTransformer;
use App\Ship\Parents\Transformers\Transformer;
use App\Ship\Requests\ApiRequest;

class GetAllOwnershipTypesRequest extends ApiRequest implements GettableTransformer
{
    public function getTransformer(): Transformer
    {
        return new OwnershipTypeTransformer();
    }
}
