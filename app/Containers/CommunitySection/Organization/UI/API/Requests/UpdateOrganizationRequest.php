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

namespace App\Containers\CommunitySection\Organization\UI\API\Requests;

use App\Containers\CommunitySection\Organization\Dto\UpdateOrganizationDto;
use App\Containers\CommunitySection\Organization\Permissions\Permissions;
use App\Ship\Collections\ValidationRulesCollection;
use App\Ship\Exceptions\ValidationFailedException;
use App\Ship\Traits\Request\HasInputId;
use Illuminate\Auth\Access\AuthorizationException;

/**
 * @method UpdateOrganizationDto getDto()
 */
class UpdateOrganizationRequest extends CreateOrganizationRequest
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
            ID => $this->getOrganizationIdValidationRules()
        ]);
    }

    public function getOrganizationIdValidationRules(): ValidationRulesCollection
    {
        return parent::getOrganizationIdValidationRules()
            ->addRequired();
    }

    public function newDto(array $data = []): UpdateOrganizationDto
    {
        return new UpdateOrganizationDto($data);
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
