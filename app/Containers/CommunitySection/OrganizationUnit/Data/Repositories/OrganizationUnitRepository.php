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

namespace App\Containers\CommunitySection\OrganizationUnit\Data\Repositories;

use App\Containers\CommunitySection\OrganizationUnit\Foundation\OrganizationUnit;
use App\Containers\CommunitySection\OrganizationUnit\Models\OrganizationUnit as OrganizationUnitModel;
use App\Ship\Parents\Repositories\Repository;

/**
 * @method OrganizationUnitModel getModel()
 */
final class OrganizationUnitRepository extends Repository
{
    protected $fieldSearchable = [
        ID => '=',
        OrganizationUnit::NAME => 'like',
        OrganizationUnit::TYPE => '='
    ];

    public function model(): string
    {
        return OrganizationUnitModel::class;
    }
}
