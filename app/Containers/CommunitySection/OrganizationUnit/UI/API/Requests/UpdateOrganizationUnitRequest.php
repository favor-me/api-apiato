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

namespace App\Containers\CommunitySection\OrganizationUnit\UI\API\Requests;

use App\Containers\CommunitySection\OrganizationUnit\Dto\UpdateOrganizationUnitDto;
use App\Containers\CommunitySection\OrganizationUnit\Permissions\Permissions;
use App\Ship\Collections\ValidationRules;
use App\Ship\Exceptions\ValidationFailedException;
use App\Ship\Traits\Request\HasInputId;
use Illuminate\Auth\Access\AuthorizationException;

/**
 * @method UpdateOrganizationUnitDto getDto()
 */
class UpdateOrganizationUnitRequest extends CreateOrganizationUnitRequest
{
    use HasInputId;

    protected array $access = [
        PERMISSIONS => Permissions::UPDATE
    ];

    protected array $urlParameters = [
        ID
    ];

    protected function afterInitialize(): void
    {
        $this->mergeDecode(ID);
    }

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            ID => $this->getOrganizationUnitIdValidationRules()
        ]);
    }

    public function getOrganizationUnitIdValidationRules(): ValidationRules
    {
        return parent::getOrganizationUnitIdValidationRules()
            ->addRequired();
    }

    public function newDto(array $data = []): UpdateOrganizationUnitDto
    {
        return new UpdateOrganizationUnitDto($data);
    }

    /**
     * @return bool
     * @throws ValidationFailedException
     * @throws AuthorizationException
     */
    protected function passesAuthorization(): bool
    {
        $result = parent::passesAuthorization();
        if ($result === true) {
            $this->throwIfEmptyInput();
        }

        return $result;
    }
}
