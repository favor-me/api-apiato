<?php

/**
 * __PROJECT_NAME__
 *
 * This file is part of the __PROJECT_NAME__ package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license __PROJECT_LICENCE__
 * @copyright Copyright (C) __PROJECT_AUTHOR__, All rights reserved ©.
 * @link __PROJECT_URL__
 * @author __PROJECT_AUTHOR__ <__PROJECT_AUTHOR__EMAIL__>
 */

namespace App\Containers\CommunitySection\OrganizationUnit\Requests;

use App\Containers\CommunitySection\OrganizationUnit\Traits\OrganizationUnitValidationRules;
use App\Containers\CommunitySection\OrganizationUnit\UI\API\Transformers\AdminOrganizationUnitTransformer;
use App\Containers\CommunitySection\OrganizationUnit\UI\API\Transformers\OrganizationUnitTransformer;
use App\Ship\Contracts\GettableTransformer;
use App\Ship\Parents\Transformers\Transformer;
use App\Ship\Requests\ApiRequest;

abstract class OrganizationUnitApiRequest extends ApiRequest implements GettableTransformer
{
    use OrganizationUnitValidationRules;

    public function getTransformer(): Transformer
    {
        return $this->isAdminUser() ? new AdminOrganizationUnitTransformer() : new OrganizationUnitTransformer();
    }
}
