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

namespace App\Ship\Commands;

use App\Containers\AppSection\Authorization\Exceptions\RoleNotFoundException;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Containers\AppSection\Authorization\Tasks\FindRoleTask;
use App\Containers\OfferSection\Item\Permissions\Permissions;
use App\Containers\OfferSection\Type\Permissions\Permissions as TypePermissions;
use App\Containers\TimetableSection\Reservation\Access\ReservationPermissions;
use App\Containers\TimetableSection\SequenceDay\Access\SequenceDayPermissions;
use App\Containers\TimetableSection\Window\Access\WindowPermissions;
use App\Ship\Parents\Commands\ConsoleCommand;

class GivePermissionToSpecialistRoleCommand extends ConsoleCommand
{
    public function __construct()
    {
        $this->description = __('ship::command.permissions:toSpecialistRole.description');
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('ship:permissions:toSpecialistRole');
    }

    /**
     * @throws RoleNotFoundException
     */
    public function handle(): void
    {
        $role = app(FindRoleTask::class)->run(Role::SPECIALIST);

        if (is_null($role)) {
            throw new RoleNotFoundException(__('ship::exception.role_not_found', [
                'role' => Role::SPECIALIST
            ]));
        }

        $permissions = $this->getPermissions();
        $role->givePermissionTo($permissions);

        $allPermissionsInfo = implode(' - ', $permissions);
        $this->info(__('ship::exception.gave_role_permission_info', [
            'role' => Role::SPECIALIST,
            'permission' => $allPermissionsInfo
        ]));
    }

    /**
     * TODO use in permissions seeder container
     * @return array
     */
    protected function getPermissions(): array
    {
        return [
            SequenceDayPermissions::CRUD,
            WindowPermissions::CRUD,
            Permissions::UPDATE,
            Permissions::DELETE,
            Permissions::CREATE,
            TypePermissions::CREATE,
            TypePermissions::DELETE,
            TypePermissions::UPDATE,
            ReservationPermissions::CREATE,
            ReservationPermissions::READ,
            ReservationPermissions::UPDATE,
            ReservationPermissions::DELETE
        ];
    }
}
