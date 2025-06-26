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

namespace App\Containers\AppSection\UserDevice\Requests;

use App\Containers\AppSection\User\Traits\HasUserValidationRules;
use App\Containers\AppSection\User\Foundation\User as BaseUser;
use App\Containers\AppSection\UserDevice\Traits\HasUserDeviceValidationRules;
use App\Containers\AppSection\UserDevice\UI\API\Transformers\UserDeviceTransformer;
use App\Ship\Contracts\GettableTransformer;
use App\Ship\Parents\Transformers\Transformer;
use App\Ship\Requests\ApiRequest;

abstract class UserDeviceApiRequest extends ApiRequest implements GettableTransformer
{
    use HasUserValidationRules;
    use HasUserDeviceValidationRules;

    protected array $urlParameters = [
        BaseUser::ID
    ];

    protected array $decode = [
        BaseUser::ID
    ];

    public function getTransformer(): Transformer
    {
        return new UserDeviceTransformer();
    }
}
