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

namespace App\Containers\OrganizationSection\Shift\UI\API\Requests;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\OrganizationSection\Shift\Dto\UpdateShiftDto;
use App\Ship\Collections\ValidationRules;
use App\Ship\Exceptions\ValidationFailedException;
use App\Ship\Traits\Request\HasInputId;
use Illuminate\Auth\Access\AuthorizationException;

/**
 * @method UpdateShiftDto getDto()
 */
class UpdateShiftRequest extends CreateShiftRequest
{
    use HasInputId;

    protected array $access = [
        ROLES => [
            RoleModel::ORGANIZATION_OWNER
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
            ID => $this->getShiftIdValidationRules()
        ]);
    }

    public function getShiftIdValidationRules(): ValidationRules
    {
        return parent::getShiftIdValidationRules()
            ->addRequired();
    }

    public function newDto(array $data = []): UpdateShiftDto
    {
        return new UpdateShiftDto($data);
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
