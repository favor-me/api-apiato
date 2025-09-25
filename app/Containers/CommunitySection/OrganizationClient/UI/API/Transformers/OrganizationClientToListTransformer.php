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

namespace App\Containers\CommunitySection\OrganizationClient\UI\API\Transformers;

use App\Containers\CommunitySection\OrganizationClient\Models\OrganizationClient as OrganizationClientModel;
use App\Containers\CommunitySection\OrganizationClient\Foundation\OrganizationClient;
use App\Ship\Transformers\ToListTransformer;
use Illuminate\Database\Eloquent\Model;

class OrganizationClientToListTransformer extends ToListTransformer
{
    public function transform(Model $model): array
    {
        return parent::transform($model) +
            [
                OrganizationClient::PHONE_NUMBER => $model->getAttribute(OrganizationClient::PHONE_NUMBER)
            ];
    }

    public function getDefaultTitle(Model|OrganizationClientModel $model): string
    {
        return $model->full_name;
    }
}
