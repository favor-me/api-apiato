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

namespace App\Containers\AppSection\User\Tests\Unit\Models;

use App\Containers\AppSection\Profile\Models\Profile;
use App\Containers\AppSection\User\Foundation\User as BaseUser;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use App\Containers\AppSection\UserDevice\Foundation\UserDevice as BaseUserDevice;
use App\Containers\AppSection\UserDevice\Models\UserDevice;
use App\Containers\LocationSection\City\Models\City;
use App\Containers\LocationSection\Country\Models\Country;
use App\Containers\LocationSection\Region\Models\Region;
use App\Containers\TelegramSection\Bot\Models\TelegraphBot;
use App\Ship\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
final class UserTest extends UnitTestCase
{
    protected User $model;

    public function setUp(): void
    {
        parent::setUp();
        $this->model = app(User::class);
    }

    public function testFillable(): void
    {
        $fields = [
            'name',
            'login',
            'birth',
            'email',
            'avatar',
            'gender',
            'surname',
            'city_id',
            'password',
            'is_admin',
            'region_id',
            'patronymic',
            'country_id',
            'phone_number',
            BaseUser::TELEGRAM_USER_NAME,
            PARAMS
        ];

        foreach ($this->model->getFillable() as $field) {
            $this->assertTrue(in_array($field, $fields));
        }
    }

    public function testHidden(): void
    {
        $this->assertSame([
            'password',
            'remember_token'
        ], $this->model->getHidden());
    }

    public function testProperties(): void
    {
        $user = User::factory()->city()->create();

        $this->assertIsString($user->phone_number);
        $this->assertIsBool($user->gender);
        $this->assertIsInt($user->city_id);
        $this->assertIsInt($user->region_id);
        $this->assertIsInt($user->country_id);
        $this->assertIsBool($user->is_admin);
        $this->assertInstanceOf(Carbon::class, $user->birth);
        $this->assertInstanceOf(Carbon::class, $user->created_at);
        $this->assertInstanceOf(Carbon::class, $user->updated_at);
        $this->assertInstanceOf(Carbon::class, $user->email_verified_at);
        $this->assertInstanceOf(Carbon::class, $user->phone_number_verified_at);
        $this->assertInstanceOf(Country::class, $user->country);
        $this->assertInstanceOf(Region::class, $user->region);
        $this->assertInstanceOf(City::class, $user->city);
    }

    public function testUserProfileRelationship(): void
    {
        $user = User::factory()->create();
        $this->assertInstanceOf(HasOne::class, $user->profile());

        Profile::factory()->create(['user_id' => $user->id]);
        $this->assertInstanceOf(Profile::class, $user->profile);
    }

    public function testCollection(): void
    {
        $this->assertInstanceOf(Collection::class, $this->model->newCollection());
    }

    public function testGetLogin(): void
    {
        $user = User::factory()->create();
        $this->assertSame('profile-' . $user->id, $user->getDefaultLogin());
    }

    public function testHasManyContacts(): void
    {
        $totalContacts = 3;
        $user = User::factory()->contacts($totalContacts)->create();

        $this->assertInstanceOf(HasMany::class, $user->contacts());
        $this->assertInstanceOf(Collection::class, $user->contacts);
        $this->assertCount($totalContacts, $user->contacts);
    }

    public function testGetFullName(): void
    {
        $user = User::factory()->create([
            'patronymic' => 'Michailovich',
            'name' => 'Sergey',
            'surname' => 'Kalistratov',
        ]);

        $this->assertSame('Kalistratov Sergey Michailovich', $user->getFullName());
    }

    public function testHasManyDevices(): void
    {
        $user = User::factory()
            ->has(UserDevice::factory()->count(2), 'devices')
            ->create();

        $this->assertInstanceOf(HasMany::class, $user->devices());
        $this->assertInstanceOf(Collection::class, $user->devices);
        $this->assertCount(2, $user->devices);
    }

    public function testHasManyActualDevices(): void
    {
        $user = User::factory()
            ->has(UserDevice::factory()->count(2), 'devices')
            ->create();

        $userDeviceNotActualData = UserDevice::factory()->make();
        $notActualDate = Carbon::now()->subWeeks(User::WEEK_LAST_ACTIVE_DEVICES + 1);

        DB::table(UserDevice::TABLE)
            ->insert([
                BaseUser::ID => $user->id,
                BaseUserDevice::MODEL => $userDeviceNotActualData->model,
                BaseUserDevice::TOKEN => $userDeviceNotActualData->token,
                UPDATED_AT => $notActualDate->toDateTimeString(),
                CREATED_AT => $notActualDate->toDateTimeString()
            ]);

        $this->assertInstanceOf(HasMany::class, $user->actualDevices());
        $this->assertInstanceOf(Collection::class, $user->actualDevices);
        $this->assertCount(2, $user->actualDevices);
        $this->assertCount(3, $user->devices);
    }

    public function testRouteNotificationForFcm(): void
    {
        $user = User::factory()->create();

        UserDevice::factory()
            ->create([
                BaseUser::ID => $user->id
            ]);

        sleep(2);

        UserDevice::factory()
            ->create([
                BaseUser::ID => $user->id
            ]);

        $this->assertCount(2, $user->devices);

        $this->assertCount(2, $user->routeNotificationForFcm());
    }

    public function testTelegramBots(): void
    {
        $user = User::factory()->create();

        TelegraphBot::factory()
            ->createdFor($user)
            ->create();

        $this->assertInstanceOf(HasMany::class, $user->telegramBots());
        $this->assertInstanceOf(Collection::class, $user->telegramBots);
        $this->assertCount(1, $user->telegramBots);
    }
}
