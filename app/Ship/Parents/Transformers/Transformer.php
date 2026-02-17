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

namespace App\Ship\Parents\Transformers;

use Apiato\Core\Abstracts\Transformers\Transformer as AbstractTransformer;
use App\Ship\SimpleTypes\Type\Money;
use App\Ship\Transformers\MoneyTransformer;
use Illuminate\Support\Carbon;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\NullResource;
use League\Fractal\Resource\Primitive;

abstract class Transformer extends AbstractTransformer
{
    public const string HUMAN_DATE_FORMAT = 'd.m.Y';

    protected string $realKeyPrefix = 'real_';

    public function addDefaultIncludes($includes): self
    {
        $includes = (array) $includes;
        foreach ($includes as $newInclude) {
            $this->addNewDefaultInclude($newInclude);
        }

        return $this;
    }

    protected function addNewDefaultInclude(string $newInclude): self
    {
        if ($this->canAddNewDefaultInclude($newInclude)) {
            array_unshift($this->defaultIncludes, $newInclude);
        }

        return $this;
    }

    public function nullOrItem($data, $transformer, $resourceKey = null): Item|NullResource
    {
        if (empty($data)) {
            return parent::null();
        }

        return $this->item($data, $transformer, $resourceKey);
    }

    public function primitiveNullOrItem($data, $transformer, $resourceKey = null): Item|Primitive
    {
        if (empty($data)) {
            return $this->primitive(null);
        }

        return $this->item($data, $transformer, $resourceKey);
    }

    public function money(mixed $money): array
    {
        if (!$money instanceof Money) {
            $money = app('money')->add($money);
        }

        return (new MoneyTransformer())->transform($money);
    }

    public function nullOrTimestamp(?Carbon $carbon): ?int
    {
        if ($carbon instanceof Carbon) {
            $this->setCarbonClientTimeZone($carbon);
            return $carbon->getTimestamp();
        }

        return null;
    }

    public function nullOrTime(?Carbon $carbon, string $format = TIME_FORMAT_SHORT): ?string
    {
        if ($carbon instanceof Carbon) {
            $this->setCarbonClientTimeZone($carbon);
            return $carbon->format($format);
        }

        return null;
    }

    public function time(?Carbon $carbon): ?array
    {
        if ($carbon instanceof Carbon) {
            $this->setCarbonClientTimeZone($carbon);

            return [
                'timestamp' => $carbon->getTimestamp(),
                'diff_for_humans' => $carbon->diffForHumans(),
                'date_for_human' => $carbon->format(self::HUMAN_DATE_FORMAT),
                'date_for_human_full' => $carbon->translatedFormat(__('time.full_to_human')),
                'date_for_human_full_with_time' => $carbon->translatedFormat(__('time.full_to_human_with_time')),
                'iso' => $carbon->toISOString(true),
                'time' => $carbon->format(TIME_FORMAT),
                'timezone' => $carbon->getTimezone()->getName(),
                'timezone_type' => $carbon->getTimezone()->getType(),
                'timezone_utc' => $carbon->getTimezone()->toOffsetTimeZone()->getName(),
                'time_short' => $carbon->format(TIME_FORMAT_SHORT),
                'is_future' => $carbon->isFuture()
            ];
        }

        return null;
    }

    /**
     * @param Carbon|null $carbon
     * @return array|null
     * @deprecated Please use time
     */
    public function date(?Carbon $carbon): ?array
    {
        if ($carbon instanceof Carbon) {
            $this->setCarbonClientTimeZone($carbon);

            return [
                'timestamp' => $carbon->getTimestamp(),
                'date_for_human' => $carbon->format(self::HUMAN_DATE_FORMAT),
                'date_for_human_full' => $carbon->translatedFormat(__('time.full_to_human')),
                'iso' => $carbon->toISOString(true),
                'timezone' => $carbon->getTimezone()->getName(),
                'timezone_type' => $carbon->getTimezone()->getType(),
                'is_future' => $carbon->isFuture()
            ];
        }

        return null;
    }

    protected function canAddNewDefaultInclude(string $newInclude): bool
    {
        return in_array($newInclude, $this->availableIncludes) && !in_array($newInclude, $this->defaultIncludes);
    }

    protected function realKey(string $key): string
    {
        return $this->realKeyPrefix . $key;
    }

    protected function setCarbonClientTimeZone(Carbon &$carbon): void
    {
        $carbon->setTimezone(client_timezone());
    }
}
