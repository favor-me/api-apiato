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

namespace App\Containers\CommunitySection\OrganizationBranch\Requests;

use App\Containers\AppSection\User\Traits\HasUserValidationRules;
use App\Containers\CommunitySection\OrganizationBranch\Traits\OrganizationBranchValidationRules;
use App\Containers\CommunitySection\OrganizationBranch\UI\API\Transformers\AdminOrganizationBranchTransformer;
use App\Containers\CommunitySection\OrganizationBranch\UI\API\Transformers\OrganizationBranchTransformer;
use App\Ship\Contracts\GettableTransformer;
use App\Ship\Parents\Transformers\Transformer;
use App\Ship\Requests\ApiRequest;

abstract class OrganizationBranchApiRequest extends ApiRequest implements GettableTransformer
{
    use HasUserValidationRules;
    use OrganizationBranchValidationRules;

    public function getTransformer(): Transformer
    {
        return $this->isAdminUser() ? new AdminOrganizationBranchTransformer() : new OrganizationBranchTransformer();
    }
}
