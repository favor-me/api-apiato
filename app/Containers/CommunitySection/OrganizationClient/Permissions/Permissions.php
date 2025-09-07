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

namespace App\Containers\CommunitySection\OrganizationClient\Permissions;

use App\Containers\CommunitySection\OrganizationClient\Facades\Container;
use App\Ship\Access\Permission;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

final class Permissions extends Permission
{
    public const CREATE = 'organization_client-create';
    public const READ = 'organization_client-read';
    public const READ_ARCHIVE = 'organization_client-read-archive';
    public const UPDATE = 'organization_client-update';
    public const DELETE = 'organization_client-delete';
    public const TRASH = 'organization_client-trash';

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
