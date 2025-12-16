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

namespace App\Containers\CommunitySection\Organization\Actions;

use App\Containers\AppSection\Authorization\Models\Role as RoleModel;
use App\Containers\AppSection\User\Dto\UpdateUserDto;
use App\Containers\AppSection\User\Foundation\User;
use App\Containers\AppSection\User\Models\User as UserModel;
use App\Containers\AppSection\User\Tasks\CreateUserByCredentialsTask;
use App\Containers\AppSection\User\Tasks\UpdateUserTask;
use App\Containers\CommunitySection\Organization\Dto\CreateOrganizationDto;
use App\Containers\CommunitySection\Organization\Dto\RegistrationOrganizationDto;
use App\Containers\CommunitySection\Organization\Foundation\Organization;
use App\Containers\CommunitySection\Organization\Models\Organization as OrganizationModel;
use App\Containers\CommunitySection\Organization\Tasks\CreateOrganizationTask;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class RegistrationOrganizationAction extends Action
{
    /**
     * @param RegistrationOrganizationDto $dto
     * @return OrganizationModel
     * @throws CreateResourceFailedException
     * @throws Throwable
     */
    public function run(RegistrationOrganizationDto $dto): OrganizationModel
    {
        try {
            DB::beginTransaction();
            $ownerUser = $this->createOrganizationUserOwner($dto);
            $organization = $this->createOrganization($ownerUser, $dto);
            $this->assignOrganizationOwner($ownerUser, $organization);
            DB::commit();
            return $organization;
        } catch (Exception $e) {
            DB::rollback();
            throw new CreateResourceFailedException($e->getMessage());
        }
    }

    /**
     * @param UserModel $ownerUser
     * @param OrganizationModel $organization
     * @return UserModel
     * @throws UpdateResourceFailedException
     */
    protected function assignOrganizationOwner(UserModel $ownerUser, OrganizationModel $organization): UserModel
    {
        try {
            $dto = new UpdateUserDto([
                ID => $ownerUser->id,
                User::IS_ORGANIZATION_OWNER => true,
                User::ORGANIZATION_ID => $organization->id
            ]);

            return app(UpdateUserTask::class)->run($dto);
        } catch (Exception $e) {
            throw new UpdateResourceFailedException($e->getMessage());
        }
    }

    /**
     * @param UserModel $ownerUser
     * @param RegistrationOrganizationDto $dto
     * @return OrganizationModel
     * @throws CreateResourceFailedException
     * @SuppressWarnings(PHPMD.LongVariable)
     */
    protected function createOrganization(UserModel $ownerUser, RegistrationOrganizationDto $dto): OrganizationModel
    {
        try {
            $createOrganizationDto = new CreateOrganizationDto([
                Organization::NAME => $dto->name,
                Organization::PHONE_NUMBER => $dto->phone_number,
                Organization::USER_OWNER_ID => $ownerUser->id,
                Organization::BANK_DATA => []
            ]);

            return app(CreateOrganizationTask::class)->run($createOrganizationDto);
        } catch (Exception $e) {
            throw new CreateResourceFailedException($e->getMessage());
        }
    }

    /**
     * @param RegistrationOrganizationDto $dto
     * @return UserModel
     * @throws CreateResourceFailedException
     */
    protected function createOrganizationUserOwner(RegistrationOrganizationDto $dto): UserModel
    {
        try {
            $user = app(CreateUserByCredentialsTask::class)->run($dto->toRegisterUserDto());
            $user->assignRole(RoleModel::ORGANIZATION_OWNER);
            return $user;
        } catch (Exception $e) {
            throw new CreateResourceFailedException($e->getMessage());
        }
    }
}
