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

namespace App\Containers\CommunitySection\Organization\Tests\Unit\Models;

use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\CommunitySection\Organization\Tests\UnitTestCase;
use App\Containers\CommunitySection\Organization\Foundation\Organization;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\OrganizationBranch\Foundation\OrganizationBranch;
use App\Containers\CommunitySection\OrganizationBranch\Models\OrganizationBranch as OrganizationBranchModel;
use App\Ship\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class OrganizationTest extends UnitTestCase
{
    protected ?OrganizationModel $model;

    public function setUp(): void
    {
        parent::setUp();
        $this->model = OrganizationModel::factory()->make();
    }

    public function testInstance(): void
    {
        $this->assertInstanceOf(OrganizationModel::class, $this->model);
    }

    public function testTableName(): void
    {
        $this->assertSame(OrganizationModel::TABLE, $this->model->getTable());
    }

    public function testTimestamp(): void
    {
        $this->assertTrue($this->model->timestamps);
    }

    public function testGetResourceKey(): void
    {
        $this->assertSame(OrganizationModel::RESOURCE_KEY, $this->model->getResourceKey());
    }

    public function testFillable(): void
    {
        $this->assertSame([
            Organization::NAME,
            Organization::INN,
            Organization::PHONE_NUMBER,
            Organization::EMAIL,
            Organization::USER_OWNER_ID,
            PARAMS
        ], $this->model->getFillable());
    }

    public function testBelongsToUserOwner(): void
    {
        $organization = OrganizationModel::factory()->create();

        $user = UserModel::factory()
            ->create([
                User::IS_ORGANIZATION_OWNER => true,
                User::ORGANIZATION_ID => $organization->id
            ]);

        $this->assertInstanceOf(BelongsTo::class, $organization->userOwner());
        $this->assertInstanceOf(UserModel::class, $organization->userOwner()->getModel());
        $this->assertSame($user->is_organization_owner, true);
        $this->assertSame($user->organization_id, $organization->id);
    }

    public function testHasManyUsers(): void
    {
        $organizationA = OrganizationModel::factory()->create();
        $organizationB = OrganizationModel::factory()->create();

        $organizationAUsers = UserModel::factory()
            ->count(4)
            ->create([
                User::ORGANIZATION_ID => $organizationA->id
            ]);

        $organizationBUsers = UserModel::factory()
            ->count(4)
            ->create([
                User::ORGANIZATION_ID => $organizationB->id
            ]);

        $this->assertInstanceOf(HasMany::class, $organizationA->users());
        $this->assertInstanceOf(UserModel::class, $organizationA->users()->getModel());

        $this->assertInstanceOf(Collection::class, $organizationA->users);
        $this->assertCount($organizationAUsers->count(), $organizationA->users);

        $this->assertCount($organizationBUsers->count(), $organizationB->users);
    }

    public function testHasManyBranches(): void
    {
        $organizationA = OrganizationModel::factory()->create();
        $organizationB = OrganizationModel::factory()->create();

        $organizationABranches = OrganizationBranchModel::factory()
            ->count(3)
            ->create([
                OrganizationBranch::ORGANIZATION_ID => $organizationA->id
            ]);

        OrganizationBranchModel::factory()
            ->count(2)
            ->create([
                OrganizationBranch::ORGANIZATION_ID => $organizationB->id
            ]);

        $this->assertInstanceOf(HasMany::class, $organizationA->branches());
        $this->assertInstanceOf(OrganizationBranchModel::class, $organizationA->branches()->getModel());
        $this->assertInstanceOf(Collection::class, $organizationA->branches);
        $this->assertCount($organizationABranches->count(), $organizationA->branches);
    }
}
