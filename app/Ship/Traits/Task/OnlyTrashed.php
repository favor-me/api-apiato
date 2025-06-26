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

namespace App\Ship\Traits\Task;

use App\Ship\Criterias\OnlyTrashedCriteria;
use App\Ship\Parents\Tasks\Task;
use Prettus\Repository\Exceptions\RepositoryException;

trait OnlyTrashed
{
    /**
     * @return Task
     * @throws RepositoryException
     */
    public function onlyTrashed(): Task
    {
        $this->repository->pushCriteria(new OnlyTrashedCriteria());
        return $this;
    }
}
