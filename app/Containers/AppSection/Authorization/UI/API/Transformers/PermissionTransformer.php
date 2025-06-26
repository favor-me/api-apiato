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

namespace App\Containers\AppSection\Authorization\UI\API\Transformers;

use App\Ship\Parents\Transformers\Transformer;
use App\Containers\AppSection\Authorization\Models\Permission;

/**
 * Class PermissionTransformer
 *
 * @package App\Containers\AppSection\Authorization\UI\API\Transformers
 */
class PermissionTransformer extends Transformer
{
    /**
     * Resources that can be included if requested.
     *
     * @var array
     */
    protected array $availableIncludes = [

    ];

    /**
     * Include resources without needing it to be requested.
     *
     * @var array
     */
    protected array $defaultIncludes = [

    ];

    /**
     * Transform data.
     *
     * @param   Permission $permission
     *
     * @return  array
     */
    public function transform(Permission $permission): array
    {
        return [
            'object' => $permission->getResourceKey(),
            'id' => $permission->getHashedKey(), // << Unique Identifier
            'name' => $permission->name, // << Unique Identifier
            'description' => $permission->description,
            'display_name' => $permission->display_name,
        ];
    }
}
