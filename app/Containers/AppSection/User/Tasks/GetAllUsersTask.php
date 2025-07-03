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

use App\Containers\AppSection\User\Data\Criterias\AdminsCriteria;
use App\Containers\AppSection\User\Data\Criterias\ClientsCriteria;
use App\Containers\AppSection\User\Data\Criterias\RoleCriteria;
use App\Containers\AppSection\User\Foundation\User;
use App\Ship\Criterias\InCriteria;
use App\Ship\Criterias\NotInCriteria;
use App\Ship\Criterias\OrderByCreationDateDescendingCriteria;
use App\Ship\Criterias\ThisEqualThatCriteria;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllUsersTask extends UserTask
{
    /**
     * @return $this
     * @throws RepositoryException
     */
    public function admins(): self
    {
        $this->repository->pushCriteria(new AdminsCriteria());
        return $this;
    }

    /**
     * @param array $ids
     * @return $this
     * @throws RepositoryException
     */
    public function byIds(array $ids): self
    {
        $this->repository->pushCriteria(new InCriteria($ids));
        return $this;
    }

    /**
     * @param array $values
     * @param string $field
     * @return $this
     * @throws RepositoryException
     */
    public function exclude(array $values, string $field = ID): self
    {
        $this->repository->pushCriteria(new NotInCriteria($values, $field));
        return $this;
    }

    /**
     * @param mixed $id
     * @return $this
     * @throws RepositoryException
     */
    public function fromOrganization(mixed $id): self
    {
        $this->repository->pushCriteria(new ThisEqualThatCriteria(User::ORGANIZATION_ID, $id));
        return $this;
    }

    /**
     * @return $this
     * @throws RepositoryException
     */
    public function clients(): self
    {
        $this->repository->pushCriteria(new ClientsCriteria());
        return $this;
    }

    /**
     * @return $this
     * @throws RepositoryException
     */
    public function ordered(): self
    {
        $this->repository->pushCriteria(new OrderByCreationDateDescendingCriteria());
        return $this;
    }

    public function run(): LengthAwarePaginator
    {
        return $this->repository->paginate();
    }

    /**
     * @param $roles
     * @return $this
     * @throws RepositoryException
     */
    public function withRole($roles): self
    {
        $this->repository->pushCriteria(new RoleCriteria($roles));
        return $this;
    }
}
