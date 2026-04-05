<?php

/**
 * FavorMe system
 *
 * This file is part of the FavorMe system package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license https://favor-me.ru/licenses/erp Proprietary license
 * @copyright Copyright (C) kalistratov.ru, All rights reserved ©.
 * @link https://kalistratov.ru
 * @author Sergey Kalistratov <sergey@kalistratov.ru>
 */

namespace App\Containers\ShiftSection\Shift\Data\Criterials;

use App\Containers\ShiftSection\Shift\Foundation\Shift;
use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Prettus\Repository\Contracts\RepositoryInterface;

class NowUserShiftCriteria extends Criteria
{
    public function __construct(
        protected int $userId
    ) {
    }

    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return Builder
     */
    public function apply($model, RepositoryInterface $repository): Builder
    {
        return $model
            ->where(CREATED_BY, $this->userId)
            ->whereRaw(self::whereRawDateTime());
    }

    public static function whereRawDateTime(): string
    {
        $now = Carbon::now();
        return implode(' ', [
            '\'' . $now->toDateTimeString() . '\' >= cast(' . Shift::START_AT . ' as datetime)',
            'and',
            '\'' . $now->toDateTimeString() . '\' <= cast(' . Shift::FINISH_AT . ' as datetime)'
        ]);
    }
}
