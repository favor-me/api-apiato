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

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use App\Containers\AppSection\UserDevice\Foundation\UserDevice as BaseUserDevice;
use App\Containers\AppSection\UserDevice\Models\UserDevice;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\OrganizationBranch\Foundation\OrganizationBranch;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch as OrganizationBranchModel;
use App\Containers\ShiftSection\Shift\Foundation\Shift;
use App\Containers\ShiftSection\Shift\Models\Shift as ShiftModel;
use App\Ship\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use JBZoo\Data\JSON;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
final class UserTest extends UnitTestCase
{
    protected UserModel $model;

    public function setUp(): void
    {
        parent::setUp();
        $this->model = app(UserModel::class);
    }

    public function testFillable(): void
    {
        $fields = [
            User::NAME,
            User::LOGIN,
            User::BIRTH,
            User::EMAIL,
            User::AVATAR,
            User::GENDER,
            User::SURNAME,
            User::PASSWORD,
            User::IS_ADMIN,
            User::IS_ORGANIZATION_OWNER,
            User::ORGANIZATION_ID,
            User::ORGANIZATION_BRANCH_ID,
            User::PATRONYMIC,
            User::PHONE_NUMBER,
            User::SHIFT_PARAMS,
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
        $user = UserModel::factory()->create();

        $this->assertIsInt($user->phone_number);
        $this->assertIsBool($user->gender);
        $this->assertIsBool($user->is_admin);
        $this->assertInstanceOf(JSON::class, $user->shift_params);
        $this->assertInstanceOf(Carbon::class, $user->birth);
        $this->assertInstanceOf(Carbon::class, $user->created_at);
        $this->assertInstanceOf(Carbon::class, $user->updated_at);
        $this->assertInstanceOf(Carbon::class, $user->email_verified_at);
        $this->assertInstanceOf(Carbon::class, $user->phone_number_verified_at);
    }

    public function testCollection(): void
    {
        $this->assertInstanceOf(Collection::class, $this->model->newCollection());
    }

    public function testGetLogin(): void
    {
        $user = UserModel::factory()->create();
        $this->assertSame('profile-' . $user->id, $user->getDefaultLogin());
    }

    public function testGetFullName(): void
    {
        $user = UserModel::factory()
            ->create([
                'patronymic' => 'Michailovich',
                'name' => 'Sergey',
                'surname' => 'Kalistratov',
            ]);

        $this->assertSame('Kalistratov Sergey Michailovich', $user->getFullName());
    }

    public function testHasManyDevices(): void
    {
        $user = UserModel::factory()
            ->has(UserDevice::factory()->count(2), 'devices')
            ->create();

        $this->assertInstanceOf(HasMany::class, $user->devices());
        $this->assertInstanceOf(Collection::class, $user->devices);
        $this->assertCount(2, $user->devices);
    }

    public function testHasManyActualDevices(): void
    {
        $user = UserModel::factory()
            ->has(UserDevice::factory()->count(2), 'devices')
            ->create();

        $userDeviceNotActualData = UserDevice::factory()->make();
        $notActualDate = Carbon::now()->subWeeks(UserModel::WEEK_LAST_ACTIVE_DEVICES + 1);

        DB::table(UserDevice::TABLE)
            ->insert([
                User::ID => $user->id,
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

    public function testBelongsToOrganization(): void
    {
        $organization = OrganizationModel::factory()->create();

        $user = UserModel::factory()
            ->create([
                User::ORGANIZATION_ID => $organization->id
            ]);

        $this->assertInstanceOf(BelongsTo::class, $user->organization());
        $this->assertInstanceOf(OrganizationModel::class, $user->organization()->getModel());
        $this->assertInstanceOf(OrganizationModel::class, $user->organization);
        $this->assertSame($organization->id, $user->organization->id);
    }

    public function testHasOrganizationOwnerRole(): void
    {
        $userA = UserModel::factory()
            ->create()
            ->assignRole(RoleModel::ORGANIZATION_OWNER);

        $this->assertTrue($userA->hasOrganizationOwnerRole());

        $userB = UserModel::factory()->create();

        $this->assertFalse($userB->hasOrganizationOwnerRole());
    }

    public function testBelongsToOrganizationBranch(): void
    {
        $organization = OrganizationModel::factory()->create();

        $organizationBranch = OrganizationBranchModel::factory()
            ->create([
                OrganizationBranch::ORGANIZATION_ID => $organization->id
            ]);

        $user = UserModel::factory()
            ->create([
                User::ORGANIZATION_ID => $organization->id,
                User::ORGANIZATION_BRANCH_ID => $organizationBranch->id
            ]);

        $this->assertInstanceOf(BelongsTo::class, $user->organizationBranch());
        $this->assertInstanceOf(OrganizationBranchModel::class, $user->organizationBranch()->getModel());
        $this->assertInstanceOf(OrganizationBranchModel::class, $user->organizationBranch);
        $this->assertSame($organizationBranch->id, $user->organizationBranch->id);
    }

    public function testIsRealOrganizationOwner(): void
    {
        $userA = UserModel::factory()
            ->create([
                User::IS_ORGANIZATION_OWNER => true
            ])
            ->assignRole(RoleModel::ORGANIZATION_OWNER);

        $this->assertFalse($userA->isRealOrganizationOwner());

        $userB = UserModel::factory()
            ->create([
                User::IS_ORGANIZATION_OWNER => true
            ]);

        $this->assertFalse($userB->isRealOrganizationOwner());

        $organizationA = OrganizationModel::factory()->create();

        $userC = $organizationA->userOwner;

        $userC
            ->setAttribute(User::ORGANIZATION_ID, $organizationA->id)
            ->setAttribute(User::IS_ORGANIZATION_OWNER, true)
            ->save();

        $userC->assignRole(RoleModel::ORGANIZATION_OWNER);

        $this->assertTrue($userC->isRealOrganizationOwner());
        $this->assertTrue($userC->isRealOrganizationOwner($organizationA->id));

        $organizationB = OrganizationModel::factory()->create();

        $this->assertFalse($userC->isRealOrganizationOwner(567));
        $this->assertFalse($userC->isRealOrganizationOwner($organizationB->id));
    }

    public function testHasOneNowShift(): void
    {
        $userB = UserModel::factory()->create();
        $userA = UserModel::factory()->create();
        $userC = UserModel::factory()->create();

        ShiftModel::factory()
            ->create([
                Shift::START_AT => Carbon::yesterday()->subHours(2),
                Shift::FINISH_AT => Carbon::yesterday()->addHours(2),
                CREATED_BY => $userB->id
            ]);

        $startAt = Carbon::now()->subHours(2);
        $finishAt = Carbon::now()->addHours(2);

        $userCShift = ShiftModel::factory()
            ->create([
                Shift::START_AT => $startAt,
                Shift::FINISH_AT => $finishAt,
                CREATED_BY => $userC->id
            ]);

        $this->assertNull($userA->nowShift);
        $this->assertNull($userB->nowShift);

        $this->assertInstanceOf(ShiftModel::class, $userC->nowShift);
        $this->assertSame($userCShift->id, $userC->nowShift->id);
    }
}
