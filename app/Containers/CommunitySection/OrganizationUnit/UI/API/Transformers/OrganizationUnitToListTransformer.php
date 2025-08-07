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

namespace App\Containers\CommunitySection\OrganizationUnit\UI\API\Transformers;

use App\Ship\Transformers\ToListTransformer;
use Illuminate\Database\Eloquent\Model;

class OrganizationUnitToListTransformer extends ToListTransformer
{
    public function getDefaultTitle(Model $model): string
    {
        return $model->getAttribute('title');
    }
}
