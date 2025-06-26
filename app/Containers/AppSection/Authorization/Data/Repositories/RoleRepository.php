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

namespace App\Containers\AppSection\Authorization\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

/**
 * Class RoleRepository
 *
 * @package App\Containers\AppSection\Authorization\Data\Repositories
 */
class RoleRepository extends Repository
{
    /**
     * Field searchable.
     *
     * @var array
     */
    protected $fieldSearchable = [
        'name' => '=',
        'display_name' => 'like',
        'description' => 'like',
    ];

    /**
     * This function relies on strict conventions.
     *
     * @return string
     */
    public function model(): string
    {
        return config('permission.models.role');
    }
}
