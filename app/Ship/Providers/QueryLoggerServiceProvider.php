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

namespace App\Ship\Providers;

use DateTimeInterface;
use App\Ship\Parents\Providers\MainServiceProvider;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;

class QueryLoggerServiceProvider extends MainServiceProvider
{
    public function register(): void
    {
        if (config('app.debug') && env('QUERIES_DEBUG') === true) {
            DB::listen(function (QueryExecuted $query) {
                $bindings = $query->bindings;
                foreach ($bindings as $key => $value) {
                    if ($value instanceof DateTimeInterface) {
                        $bindings[$key] = $value->format(
                            DB::getQueryGrammar()
                                ->getDateFormat()
                        );
                    } elseif (is_bool($value)) {
                        $bindings[$key] = (int)$value;
                    }
                }
                $fullQuery = vsprintf(str_replace(['%', '?'], ['%%', '%s'], $query->sql), $bindings);

                $result = $query->connectionName . ' (' . $query->time . '): ' . $fullQuery;

                dump($result);
            });
        }
    }
}
