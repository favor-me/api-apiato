<?php

/**
 * __PROJECT_NAME__
 *
 * This file is part of the __PROJECT_NAME__ package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license __PROJECT_LICENCE__
 * @copyright Copyright (C) __PROJECT_AUTHOR__, All rights reserved ©.
 * @link __PROJECT_URL__
 * @author __PROJECT_AUTHOR__ <__PROJECT_AUTHOR__EMAIL__>
 */

namespace App\Containers\CommunitySection\OrganizationUnit\Permissions;

use App\Containers\CommunitySection\OrganizationUnit\Facades\Container;
use App\Ship\Access\Permission;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

final class Permissions extends Permission
{
    public const CREATE = 'organization_unit-create';
    public const READ = 'organization_unit-read';
    public const READ_ARCHIVE = 'organization_unit-read-archive';
    public const UPDATE = 'organization_unit-update';
    public const DELETE = 'organization_unit-delete';
    public const TRASH = 'organization_unit-trash';

    /**
     * @return Collection
     * @throws UnknownProperties
     */
    public function getList(): Collection
    {
        return collect([
            $this->createPermissionDto(self::READ, [
                'display_name' => $this->getTranslateKey('read.name'),
                'description' => $this->getTranslateKey('read.description')
            ]),
            $this->createPermissionDto(self::READ_ARCHIVE, [
                'display_name' => $this->getTranslateKey('read_archive.name'),
                'description' => $this->getTranslateKey('read_archive.description')
            ]),
            $this->createPermissionDto(self::CREATE, [
                'display_name' => $this->getTranslateKey('create.name'),
                'description' => $this->getTranslateKey('create.description')
            ]),
            $this->createPermissionDto(self::UPDATE, [
                'display_name' => $this->getTranslateKey('update.name'),
                'description' => $this->getTranslateKey('update.description')
            ]),
            $this->createPermissionDto(self::DELETE, [
                'display_name' => $this->getTranslateKey('delete.name'),
                'description' => $this->getTranslateKey('delete.description')
            ]),
            $this->createPermissionDto(self::TRASH, [
                'display_name' => $this->getTranslateKey('trash.name'),
                'description' => $this->getTranslateKey('trash.description')
            ])
        ]);
    }

    public function getSection(): string
    {
        return Container::getSectionName();
    }

    public function getContainer(): string
    {
        return Container::getName();
    }
}
