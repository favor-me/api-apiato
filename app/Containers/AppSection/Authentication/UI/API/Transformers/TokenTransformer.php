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

namespace App\Containers\AppSection\Authentication\UI\API\Transformers;

use App\Ship\Parents\Transformers\Transformer;

class TokenTransformer extends Transformer
{
    public function transform($token): array
    {
        return [
            'object' => 'Token',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => config('apiato.api.expires-in'),
        ];
    }
}
