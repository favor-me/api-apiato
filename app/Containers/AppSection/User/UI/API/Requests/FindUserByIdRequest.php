<?php

/**
 * Beauty application system
 *
 * This file is part of the Beauty application system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     Proprietary
 * @copyright   Copyright (C) kalistratov.ru, All rights reserved.
 * @link        https://kalistratov.ru
 */

namespace App\Containers\AppSection\User\UI\API\Requests;

use App\Containers\AppSection\User\Requests\UserApiRequest;
use App\Containers\AppSection\User\Traits\IsOwnerTrait;
use App\Ship\Collections\ValidationRules;
use App\Ship\Traits\Request\HasInputId;

class FindUserByIdRequest extends UserApiRequest
{
    use HasInputId;
    use IsOwnerTrait;

    protected array $access = [
        PERMISSIONS => 'search-users',
        ROLES => ''
    ];

    protected array $decode = [
        ID
    ];

    protected array $urlParameters = [
        ID
    ];

    public function authorize(): bool
    {
        return $this->check([
            'hasAccess|isOwner'
        ]);
    }

    public function rules(): array
    {
        return [
            ID => $this->getUserIdValidationRules()
        ];
    }

    public function getUserIdValidationRules(): ValidationRules
    {
        return parent::getUserIdValidationRules()
            ->addRequired();
    }
}
