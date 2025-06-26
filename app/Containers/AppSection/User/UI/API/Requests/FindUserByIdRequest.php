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

class FindUserByIdRequest extends UserApiRequest
{
    use IsOwnerTrait;

    protected array $access = [
        'permissions' => 'search-users',
        'roles' => ''
    ];

    protected array $decode = [
        'id'
    ];

    protected array $urlParameters = [
        'id'
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
            'id' => $this->getUserIdValidationRules()->addRequired()
        ];
    }
}
