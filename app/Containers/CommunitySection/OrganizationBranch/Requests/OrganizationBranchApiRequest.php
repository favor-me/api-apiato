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

use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Traits\HasUserValidationRules;
use App\Containers\AppSection\User\Traits\IsOrganizationUser;
use App\Containers\CommunitySection\OrganizationBranch\Foundation\OrganizationBranch;
use App\Containers\CommunitySection\OrganizationBranch\Traits\OrganizationBranchValidationRules;
use App\Containers\CommunitySection\OrganizationBranch\UI\API\Transformers\AdminOrganizationBranchTransformer;
use App\Containers\CommunitySection\OrganizationBranch\UI\API\Transformers\OrganizationBranchTransformer;
use App\Ship\Contracts\GettableTransformer;
use App\Ship\Parents\Transformers\Transformer;
use App\Ship\Requests\ApiRequest;

/**
 * @property-read mixed $organization_id
 */
abstract class OrganizationBranchApiRequest extends ApiRequest implements GettableTransformer
{
    use IsOrganizationUser;
    use HasUserValidationRules;
    use OrganizationBranchValidationRules;

    protected array $decode = [
        OrganizationBranch::ORGANIZATION_ID
    ];

    public function getTransformer(): Transformer
    {
        return $this->isAdminUser() ? new AdminOrganizationBranchTransformer() : new OrganizationBranchTransformer();
    }

    protected function prepareForValidation(): void
    {
        $this->prepareForValidationOrganizationId();
    }

    protected function prepareForValidationOrganizationId(): void
    {
        if (!is_null($this->user())) {
            $this->merge([
                OrganizationBranch::ORGANIZATION_ID => $this->user()->getHashedKey(User::ORGANIZATION_ID)
            ]);
        }
    }

    protected function getCheckAuthorizeMethods(): array
    {
        return array_merge(parent::getCheckAuthorizeMethods(), [
            'isOrganizationUser'
        ]);
    }
}
