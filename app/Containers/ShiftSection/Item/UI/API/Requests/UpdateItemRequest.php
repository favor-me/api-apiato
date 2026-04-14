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

namespace App\Containers\ShiftSection\Item\UI\API\Requests;

use App\Containers\ShiftSection\Item\Dto\UpdateItemDto;
use App\Containers\ShiftSection\Item\Validation\Rules\IsOrganizationShiftItemRule;
use App\Ship\Collections\ValidationRules;
use App\Ship\Exceptions\ValidationFailedException;
use App\Ship\Traits\Request\HasInputId;
use Illuminate\Auth\Access\AuthorizationException;

/**
 * @method UpdateItemDto getDto()
 */
class UpdateItemRequest extends CreateItemRequest
{
    use HasInputId;

    protected array $urlParameters = [
        ID
    ];

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            ID => $this->getItemIdValidationRules()
        ]);
    }

    public function getItemTypeValidationRules(): ValidationRules
    {
        return parent::getItemTypeValidationRules()
            ->removeRequired();
    }

    public function getShiftIdValidationRules(): ValidationRules
    {
        return parent::getShiftIdValidationRules()
            ->removeRequired();
    }

    public function getItemIdValidationRules(): ValidationRules
    {
        return validation_rules()
            ->add(
                new IsOrganizationShiftItemRule($this->user()->organization_id)
            )
            ->addRequired();
    }

    public function newDto(array $data = []): UpdateItemDto
    {
        return new UpdateItemDto($data);
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

    protected function afterInitialize(): void
    {
        parent::afterInitialize();
        $this->mergeDecode(ID);
    }
}
