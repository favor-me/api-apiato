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

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Criterias\RoleCriteria;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Traits\SetColumns;
use Exception;
use Prettus\Repository\Exceptions\RepositoryException;

class FindUserByIdTask extends UserTask
{
    use SetColumns;

    /**
     * @param string|int $id
     * @return User
     * @throws NotFoundException
     */
    public function run(string|int $id): User
    {
        try {
            return $this->repository->find($id, $this->columns);
        } catch (Exception $e) {
            throw new NotFoundException($e->getMessage());
        }
    }

    /**
     * @param string $role
     * @return $this
     * @throws RepositoryException
     */
    public function role(string $role): self
    {
        $this->repository->pushCriteria(new RoleCriteria($role));
        return $this;
    }
}
