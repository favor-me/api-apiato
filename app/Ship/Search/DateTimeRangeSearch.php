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

namespace App\Ship\Search;

use App\Ship\Exceptions\InvalidSystemDateFormatException;
use App\Ship\Support\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class DateTimeRangeSearch
{
    protected ?string $field;
    protected array $parsedValue = [];
    protected Builder $query;
    protected ?string $value;
    protected string $whereMode;

    public function __construct(Builder $query, $field, $value, string $whereMode)
    {
        $this->query = $query;
        $this->field = $field;
        $this->value = $value;

        $this->whereMode = Str::lower($whereMode);

        $separator = str_contains($value, '-') ? '-' : '|';
        $this->parsedValue = explode($separator, $value);
    }

    /**
     * @throws Exception
     */
    public function __invoke(): void
    {
        $totalDetails = count($this->parsedValue);

        //  For short code.
        if ($totalDetails === 1) {
            $this->runShortCode();
        }

        //  For range date.
        if ($totalDetails === 2) {
            list($from, $to) = $this->parsedValue;
            $this->whereRangeDate($from, $to);
        }
    }

    protected function getQueryWhereMethod(): string
    {
        return $this->whereMode === 'and' ? 'whereDate' : 'orWhereDate';
    }

    protected function getSearchMethod(string $name): string
    {
        return 'search' . Str::ucfirst(Str::camel($name));
    }

    /**
     * @return void
     * @throws InvalidSystemDateFormatException
     */
    protected function runShortCode(): void
    {
        $method = $this->getSearchMethod($this->parsedValue[0]);

        if (method_exists($this, $method)) {
            $this->$method();
        } else {
            $queryMethod = $this->getQueryWhereMethod();
            $date = Carbon::createFromSystemDate($this->parsedValue[0]);
            $this->query->$queryMethod($this->field, $date);
        }
    }

    /**
     * @throws Exception
     */
    protected function searchLastMonth(): void
    {
        $to = Carbon::today();
        $from = Carbon::today()->subDays(30);

        $this->whereRangeDate($from, $to);
    }

    /**
     * @throws Exception
     */
    protected function searchLastSevenDays(): void
    {
        $to = Carbon::today();
        $from = Carbon::today()->subDays(6);

        $this->whereRangeDate($from, $to);
    }

    protected function searchNull(): void
    {
        if ($this->whereMode === 'and') {
            $this->query->whereNull($this->field);
        } else {
            $this->query->orWhereNull($this->field);
        }
    }

    /**
     * @throws Exception
     */
    protected function searchLastThreeDays(): void
    {
        $to = Carbon::today();
        $from = Carbon::today()->subDays(2);

        $this->whereRangeDate($from, $to);
    }

    protected function searchToday(): void
    {
        $queryMethod = $this->getQueryWhereMethod();
        $this->query->$queryMethod($this->field, Carbon::today());
    }

    /**
     * @param mixed $from
     * @param mixed $to
     * @throws Exception
     */
    protected function whereRangeDate(mixed $from, mixed $to): void
    {
        if (!$from instanceof Carbon) {
            $from = Carbon::createFromSystemDate($from);
        }

        if (!$to instanceof Carbon) {
            $to = Carbon::createFromSystemDate($to);
        }

        $queryMethod = $this->getQueryWhereMethod();

        $this->query
            ->$queryMethod($this->field, '>=', $from->toDateString())
            ->$queryMethod($this->field, '<=', $to->toDateString());
    }
}
