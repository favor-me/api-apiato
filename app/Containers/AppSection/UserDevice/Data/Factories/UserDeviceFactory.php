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

namespace App\Containers\AppSection\UserDevice\Data\Factories;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\UserDevice\Models\UserDevice;
use App\Containers\AppSection\UserDevice\Foundation\UserDevice as BaseUserDevice;
use App\Containers\AppSection\User\Foundation\User as BaseUser;
use App\Ship\Database\Eloquent\Collection;
use App\Ship\Parents\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * @method UserDevice make($attributes = [], ?Model $parent = null)
 * @method Collection|UserDevice create($attributes = [], ?Model $parent = null)
 */
final class UserDeviceFactory extends Factory
{
    protected $model = UserDevice::class;

    public function definition(): array
    {
        return [
            BaseUser::ID => User::factory(),
            BaseUserDevice::MODEL => $this->model(),
            BaseUserDevice::TOKEN => implode('-', [
                $this->faker->uuid(),
                $this->faker->uuid(),
                $this->faker->uuid(),
                $this->faker->uuid()
            ])
        ];
    }

    public function user(mixed $user): self
    {
        if ($user instanceof User) {
            $user = $user->id;
        }

        return $this->state(function () use ($user) {
            return [
                BaseUser::ID => $user
            ];
        });
    }

    public function iPhone(?string $model = null): self
    {
        return $this->stateDeviceModel('Iphone', $model, '15');
    }

    public function google(?string $model = null): self
    {
        return $this->stateDeviceModel('Google Pixel', $model, '8');
    }

    public function samsung(?string $model = null): self
    {
        return $this->stateDeviceModel('Samsung', $model, 'S10');
    }

    protected function stateDeviceModel(string $name, ?string $model, string $defaultModel): self
    {
        $model = $this->getDefaultDeviceModel($model, $defaultModel);

        return $this->state(function () use ($name, $model) {
            return [
                BaseUserDevice::MODEL => $name . ' ' . $model
            ];
        });
    }

    protected function getDefaultDeviceModel(?string $model, string $default): string
    {
        return is_null($model) ? $default : $model;
    }

    protected function model()
    {
        $devices = [
            'Iphone 15',
            'Iphone 14',
            'Iphone 13',
            'Google Pixel 8',
            'Google Pixel 7',
            'Google Pixel 6',
            'Samsung S10',
            'Samsung S11'
        ];

        return Arr::random($devices);
    }
}
