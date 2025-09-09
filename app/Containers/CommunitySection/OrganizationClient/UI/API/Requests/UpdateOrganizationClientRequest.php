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

namespace App\Containers\CommunitySection\OrganizationClient\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\CommunitySection\OrganizationClient\Dto\UpdateOrganizationClientDto;
use App\Ship\Collections\ValidationRules;
use App\Ship\Exceptions\ValidationFailedException;
use App\Ship\Traits\Request\HasInputId;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\Rules\Unique;

/**
 * @method UpdateOrganizationClientDto getDto()
 */
class UpdateOrganizationClientRequest extends CreateOrganizationClientRequest
{
    use HasInputId;

    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER,
            RoleModel::ORGANIZATION_WORKER
        ]
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
            ID => $this->getOrganizationClientIdValidationRules()
        ]);
    }

    public function getOrganizationClientIdValidationRules(): ValidationRules
    {
        return parent::getOrganizationClientIdValidationRules()
            ->addRequired();
    }

    public function newDto(array $data = []): UpdateOrganizationClientDto
    {
        return new UpdateOrganizationClientDto($data);
    }

    public function getOrganizationClientPhoneNumberUnique(string $column = 'NULL'): Unique
    {
        return parent::getOrganizationClientPhoneNumberUnique($column)
            ->whereNot(ID, $this->id);
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
