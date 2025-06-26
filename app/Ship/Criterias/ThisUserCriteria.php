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

namespace App\Ship\Criterias;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use App\Ship\Parents\Criterias\Criteria;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

/**
 * Class ThisUserCriteria
 *
 * @package App\Ship\Criterias
 */
class ThisUserCriteria extends Criteria
{
    /**
     * Hold user id.
     *
     * @var int
     */
    private $userId;

    /**
     * ThisUserCriteria constructor.
     *
     * @param $userId
     */
    public function __construct($userId = null)
    {
        $this->userId = $userId;
    }

    /**
     * Apply criteria in query repository.
     *
     * @param   $model
     * @param   PrettusRepositoryInterface $repository
     *
     * @return  Builder
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function apply($model, PrettusRepositoryInterface $repository)
    {
        if (!$this->userId) {
            $this->userId = Auth::user()->id;
        }

        return $model->where('user_id', '=', $this->userId);
    }
}
