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

namespace App\Containers\CommunitySection\OrganizationBranch\Data\Repositories;

use App\Containers\CommunitySection\OrganizationBranch\Foundation\OrganizationBranch;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch as OrganizationBranchModel;
use App\Ship\Parents\Repositories\Repository;

/**
 * @method OrganizationBranchModel getModel()
 */
final class OrganizationBranchRepository extends Repository
{
    protected $fieldSearchable = [
        ID => '=',
        OrganizationBranch::ORGANIZATION_ID => '=',
        OrganizationBranch::NAME => 'like'
    ];

    public function model(): string
    {
        return OrganizationBranchModel::class;
    }
}
